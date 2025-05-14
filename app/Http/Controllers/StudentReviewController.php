<?php
// app/Http/Controllers/StudentReviewController.php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentReviewController extends Controller
{
    public function create($applicationId)
    {
        $application = JobApplication::with('job.employer')
                                     ->findOrFail($applicationId);

        if ($application->status !== 'completed') {
            abort(403);
        }

        return view('student.review.create', compact('application'));
    }

    public function store(Request $request, $applicationId)
{
    $data = $request->validate([
        'rating' => 'required|integer|min:1|max:5',
        // removed 'comment'
    ]);

    $application = JobApplication::findOrFail($applicationId);

    Review::create([
        'job_application_id' => $applicationId,
        'job_id'             => $application->job_id,
        'student_id'         => Auth::id(),
        'rating'             => $data['rating'],
    ]);

    return redirect()
        ->route('student.applied_jobs')
        ->with('success', 'Thanks for your review!');
}
}