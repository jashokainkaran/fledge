<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;  // or extend your App\Http\Controllers\Controller
use Illuminate\Support\Facades\Auth;
use App\Models\Job;
use App\Models\JobApplication;

class StudentDashboardController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
    {
        $studentId = Auth::id();

        // 1) Latest 5 approved jobs
        $latestJobs = Job::where('status', 'approved')
                         ->latest()
                         ->take(5)
                         ->get();

        // 2) All applications for this student
        $appliedJobs = JobApplication::with('job')
                                     ->where('student_id', $studentId)
                                     ->orderByDesc('created_at')
                                     ->get();

        // 3) Completed applications for this student
        $completedJobs = JobApplication::with(['job', 'review'])
                                       ->where('student_id', $studentId)
                                       ->where('status', 'Completed')    // if you track status here
                                       ->whereNotNull('end_date')        
                                       ->whereDate('end_date', '<=', now())
                                       ->orderByDesc('end_date')
                                       ->get();

        return view('student.dashboard', [
            'latestJobs'   => $latestJobs,
            'appliedJobs'  => $appliedJobs,
            'completed'    => $completedJobs,   // pass it in as $completed
        ]);
    }


    /**
     * Show all applications with job info.
     */
    public function applications()
    {
        $applications = auth()->user()
            ->applications()
            ->with('job')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('student.applied_jobs', compact('applications'));
    }

    /**
     * Fallback index method.
     */
    public function index()
    {
        $appliedJobs = collect();
        $latestJobs = collect();
        $completed = collect();

        return view('student.dashboard', compact('latestJobs', 'appliedJobs', 'completed'));
    }

    public function appliedJobs()
    {
        // 1) Get current student’s ID
        $studentId = Auth::id();  

        // 2) Load their applications, eager-loading the job info
        $applications = Application::with('job')
            ->where('student_id', $studentId)
            ->orderBy('created_at', 'desc')
            ->get();

        // 3) Pass to a view
        return view('student.applied_jobs', compact('applications'));
    }

   
    
}
