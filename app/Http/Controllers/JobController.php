<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;

class JobController extends Controller
{
    /**
     * Show the homepage (renders resources/views/index.blade.php).
     */
    public function home()
    {
        $latestJobs = Job::with('employer')->latest()->take(5)->get();
        return view('index', compact('latestJobs'));
    }

    /**
     * Job listings page (renders resources/views/jobs.blade.php)
     * and handles AJAX filtering on /jobs.
     */
    public function index(Request $request)
    {
        // Eager-load the employer relationship here
        $query = Job::with('employer');

        // Apply keyword search
        if ($request->has('keyword') && $request->keyword != '') {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', '%' . $keyword . '%')
                  ->orWhere('description', 'like', '%' . $keyword . '%');
            });
        }

        // Apply filters based on the request
        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }

        if ($request->has('jobType') && $request->jobType != '') {
            $query->where('job_type', $request->jobType);
        }

        if ($request->has('workingHours') && $request->workingHours != '') {
            $query->where('working_hours', $request->workingHours);
        }

        if ($request->has('location') && $request->location != '') {
            $query->where('location', $request->location);
        }

        // Get the filtered jobs
        $jobs = $query->latest()->get();

        if ($request->ajax()) {
            return view('partials.job_listings', compact('jobs'));
        }
        return view('jobs', compact('jobs'));
    }
}