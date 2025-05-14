<?php

// app/Http/Controllers/EmployerDashboardController.php

namespace App\Http\Controllers;


use App\Models\Job;
use Illuminate\Support\Facades\Auth;

class EmployerDashboardController extends Controller
{
    public function index()
{
    $emp = Auth::guard('employer')->user();

    if ($emp->status === 'pending') {
        return view('employer.pending');
    }

    if ($emp->status === 'rejected') {
        return view('employer.reject');
    }

    // verified
    $jobs = auth()->user()->jobs()->with(['applications'=>fn($q)=>$q->where('status','!=','rejected')])
             ->orderBy('created_at','desc')
             ->get();

    return view('employer.dashboard', compact('jobs'));
}

public function verifyEmployer(Employer $employer, bool $approved)
{
    $employer->status = $approved ? 'verified' : 'rejected';
    $employer->save();

    $notification = $approved
        ? new EmployerApproved($employer)
        : new EmployerRejected($employer);

    $employer->notify($notification);
}

}
