<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NewApplicationReceived;

class StudentJobController extends Controller
{
    // Show form
    public function showApplyForm(Job $job)
    {
        return view('student.apply', compact('job'));
    }

    public function submitApplication(Request $request, Job $job)
{
    // Only validate the CV now
    $request->validate([
        'cv' => 'required|file|mimes:pdf|max:2048',
    ]);

    // Store the uploaded CV
    $cvPath = $request->file('cv')->store('cvs', 'public');

    // Create the application record without any cover-letter field
    JobApplication::create([
        'student_id' => Auth::id(),  // or 'student_id' if that’s your column
        'job_id'     => $job->id,      // or 'job_id' if that’s your column
        'cv_path'     => $cvPath,
        // no 'cover_letter' or 'message' here
    ]);

    // Redirect to the applied jobs page (or dashboard) with success
    return redirect()
        ->route('applied_jobs')        // or 'student.applied_jobs'
        ->with('success', 'Application submitted successfully!');
}


    public function markCompleted($applicationId)
    {
        $application = JobApplication::findOrFail($applicationId);

        if ($application->status === 'Accepted') {
            $application->status = 'Completed';
            $application->save();
        }

        return redirect()->route('student.dashboard')->with('success', 'Job marked as completed.');
    }

     // List applied jobs
    public function applied()
    {
        $student = Auth::user(); // assuming student guard
        $applications = JobApplication::with('job')
            ->where('student_id', $student->id)
            ->orderBy('created_at','desc')
            ->get();

        return view('student.applied_jobs', [
            'applications' => $applications,
        ]);
    }
    public function completed()
    {
        $student = auth()->guard('student')->user();

        if (!$student) {
            return redirect()->route('student.login')->with('error', 'Please login to view your completed jobs.');
        }

        $completedJobs = $student->completedJobs;
        return view('student.completed-job', compact('completedJobs'));
    }
}