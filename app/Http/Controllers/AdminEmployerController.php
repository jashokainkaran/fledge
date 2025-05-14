<?php

namespace App\Http\Controllers;


use App\Models\Employer;
use App\Models\Review;
use App\Models\Job;
use Illuminate\Http\Request;
use App\Notifications\EmployerVerified;
use App\Notifications\EmployerRejected; // Make sure this is included at the top
use App\Notifications\JobApproved;
use App\Notifications\JobRejected;

class AdminEmployerController extends Controller
{
    /**
     * 1) Pending Employers
     */
    public function index()
    {
        $pendingEmployers = Employer::where('status', 'pending')->get();
        return view('admin.employer.pending', compact('pendingEmployers'));
    }

    public function verify($id)
    {
        $employer = Employer::findOrFail($id);
        $employer->update(['status' => 'verified']);
        $employer->notify(new EmployerVerified($employer));

        return back()->with('success', 'Employer verified successfully.');
    }

    public function reject($id)
{
    $employer = Employer::findOrFail($id);
    $employer->update(['status' => 'rejected']);
    $employer->notify(new EmployerRejected());

    return back()->with('error', 'Employer rejected.');
}
    /**
     * 2) Pending Jobs
     */
    public function pendingJobs()
    {
        $pendingJobs = Job::where('status', 'pending')
                          ->with('employer')
                          ->get();
        return view('admin.jobs.pending', compact('pendingJobs'));
    }

    public function approveJob($id)
    {
        $job = Job::findOrFail($id);
        $job->update(['status' => 'approved']);

        // Send the notification to the employer
        $job->employer->notify(new JobApproved($job));

        return back()->with('success', 'Job approved.');
    }

    public function rejectJob($id)
    {   $job = Job::findOrFail($id);
        $job->update(['status' => 'rejected']);
        $job->employer->notify(new JobRejected($job));
        return back()->with('error', 'Job rejected.');
    }

    /**
     * 3) Student Reviews
     */
    public function showReviews()
    {
        $reviews = Review::with('student', 'application.job.employer')
                         ->latest()
                         ->paginate(20);
        return view('admin.review.index', compact('reviews'));
    }

    public function deleteReview($id)
    {
        Review::findOrFail($id)->delete();
        return back()->with('success', 'Review deleted successfully.');
    }

    /**
     * 4) Dashboard summarizes all sections
     */
    public function dashboard()
    {
        $pendingEmployers = Employer::where('status', 'pending')->get();
        $pendingJobs      = Job::where('status', 'pending')->get();
        $recentReviews    = Review::with('student')
                                  ->latest()
                                  ->limit(10)
                                  ->get();

        return view('admin.dashboard', compact(
            'pendingEmployers',
            'pendingJobs',
            'recentReviews'
        ));
    }
}