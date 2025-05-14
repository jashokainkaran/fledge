<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NewApplicationReceived;

class StudentJobController extends Controller
{
    /**
     * Display the application form for a specific job.
     */
    public function showApplyForm(Job $job)
    {
        return view('student.apply', compact('job'));
    }

    /**
     * Handle the submission of a job application by a student.
     */
    public function submitApplication(Request $request, Job $job)
    {
        // Validate the incoming request data
        $request->validate([
            'message' => 'required|string',
            'cv'      => 'required|file|mimes:pdf|max:2048',
        ]);

        // Store the CV file in public storage
        $cvPath = $request->file('cv')->store('cvs', 'public');

        // Create the job application record
        $application = JobApplication::create([
            'students_id'  => Auth::id(),
            'jobs_id'      => $job->id,
            'cover_letter' => $request->input('message'),
            'cv_path'      => $cvPath,
            'status'       => 'Pending',
        ]);

        // Notify the employer of the new application
        $application->job->employer->notify(new NewApplicationReceived($application));

        // Redirect back with a success message
        return back()->with('success', 'Application submitted successfully!');
    }

    /**
     * Mark an accepted application as completed by the student.
     */
    public function markCompleted($applicationId)
    {
        $application = JobApplication::findOrFail($applicationId);

        if ($application->status === 'Accepted') {
            $application->status = 'Completed';
            $application->save();
        }

        return redirect()->route('student.dashboard')
                         ->with('success', 'Job marked as completed.');
    }

    /**
     * Display the jobs the student has applied to.
     */
    public function applied()
    {
        $student = Auth::guard('student')->user();

        if (!$student) {
            return redirect()->route('student.login')
                             ->with('error', 'Please login to view your applied jobs.');
        }

        $appliedJobs = $student->appliedJobs;
        return view('student.applied_jobs', compact('appliedJobs'));
    }

    /**
     * Display the jobs the student has completed.
     */
    public function completed()
    {
        $student = Auth::guard('student')->user();

        if (!$student) {
            return redirect()->route('student.login')
                             ->with('error', 'Please login to view your completed jobs.');
        }

        $completedJobs = $student->completedJobs;
        return view('student.completed_jobs', compact('completedJobs'));
    }
}