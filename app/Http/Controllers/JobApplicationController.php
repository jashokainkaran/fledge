<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Application;
use Illuminate\Support\Facades\Storage;

class JobApplicationController extends Controller
{
    // Method to handle job application submission
    public function submitApplication(Request $request, $jobId)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'cv' => 'required|file|mimes:pdf|max:2048', // PDF validation, max 2MB
        ]);

        $job = Job::findOrFail($jobId);

        // Handle the file upload
        $cvPath = $request->file('cv')->store('cv_files', 'public');

        // Create a new application
        Application::create([
            'job_id' => $job->id,
            'student_id' => auth()->user()->id, // Assuming you're using authentication
            'cover_letter' => $request->message,
            'cv_path' => $cvPath,
        ]);

        return redirect()->route('job.show', $jobId)
            ->with('success', 'Application submitted successfully!');
    }
}
