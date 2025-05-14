<?php


namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ApplicationDecision;  // make sure this exists


class EmployerJobController extends Controller
{
    // Show the job creation form
    public function create()
    {
        return view('employer.create-job');
    }

    // Store the new job
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'         => 'required|string|max:255',
            'category'      => 'required|string|max:100',
            'job_type'      => 'required|string|max:50',
            'working_hours' => 'required|string|max:50',
            'location'      => 'required|string|max:255',
            'pay_rate'      => 'required|numeric',
            'description'   => 'nullable|string',
        ]);

        $data['employer_id'] = Auth::id();
        $data['status']      = 'pending';

        Job::create($data);

        return redirect()
            ->route('employer.dashboard')
            ->with('success', 'Job posted (pending admin approval).');
    }

    // Show the edit form
    public function edit(Job $job)
    {
        // Ensure the employer owns the job
        if ($job->employer_id !== Auth::id()) {
            abort(403);
        }
        return view('employer.edit-job', compact('job'));
    }

    // Handle the update submission
    public function update(Request $request, Job $job)
    {
        // Ensure the employer owns the job
        if ($job->employer_id !== Auth::id()) {
            abort(403);
        }

        $data = $request->validate([
            'title'         => 'required|string|max:255',
            'category'      => 'required|string|max:100',
            'job_type'      => 'required|string|max:50',
            'working_hours' => 'required|string|max:50',
            'location'      => 'required|string|max:255',
            'pay_rate'      => 'required|numeric',
            'description'   => 'nullable|string',
        ]);

        $job->update($data);

        return redirect()
            ->route('employer.dashboard')
            ->with('success', 'Job updated successfully.');
    }

    // Delete a job
    public function destroy(Job $job)
    {
        // Ensure the employer owns the job
        if ($job->employer_id !== Auth::id()) {
            abort(403);
        }

        $job->delete();

        return redirect()
            ->route('employer.dashboard')
            ->with('success', 'Job deleted successfully.');
    }

    public function viewApplication($jobId, $applicationId)
    {
        $job = Job::where('id', $jobId)
                  ->where('employer_id', auth()->id())
                  ->firstOrFail();

        $application = JobApplication::where('id', $applicationId)
                                     ->where('job_id', $job->id)
                                     ->firstOrFail();

        return view('employer.view-application', compact('job','application'));
    }

    
     
    public function applicants($jobId)
    {
        $job = Job::where('id', $jobId)
                  ->where('employer_id', auth()->id())
                  ->firstOrFail();

        $applications = $job->applications()
                            ->with('student')
                            ->orderBy('created_at','desc')
                            ->get();

        return view('employer.applicants', compact('job', 'applications'));
    }

    
    public function approveApplication($jobId, $appId)
    {
        $application = JobApplication::where('id', $appId)
                                     ->where('job_id', $jobId)
                                     ->firstOrFail();

        $application->status = 'accepted';
        $application->save();

        $application->student->notify(
            new ApplicationDecision($application)
        );
                return back()->with('success', 'Application approved and student notified.');

    }

public function rejectApplication($jobId, $appId)
    {
        $application = JobApplication::where('id', $appId)
                                     ->where('job_id', $jobId)
                                     ->firstOrFail();

        $application->status = 'rejected';
        $application->save();

        $application->student->notify(
            new ApplicationDecision($application)
        );
                return back()->with('error', 'Application rejected and student notified.');

    }
// 1) Show a form to pick start/end
public function showScheduleForm($jobId, $appId)
{
    $app = JobApplication::where('id',$appId)
         ->where('job_id',$jobId)->firstOrFail();

    return view('employer.schedule-application', compact('app'));
}

// 2) Save start & end
public function scheduleApplication(Request $req, $jobId, $appId)
{
    $data = $req->validate([
      'start_date' => 'required|date',
      'end_date'   => 'required|date|after_or_equal:start_date',
    ]);

    $app = JobApplication::where('id',$appId)
         ->where('job_id',$jobId)->firstOrFail();

    $app->update($data + ['status'=>'scheduled']);

    return redirect()
        ->route('employer.job.view-application', [$jobId,$appId])
        ->with('success','Schedule set.');
}

// 3) Complete
public function completeApplication($jobId, $appId)
{
    $app = JobApplication::where('id',$appId)
         ->where('job_id',$jobId)->firstOrFail();

    $app->update(['status'=>'completed']);

    return redirect()
        ->route('employer.job.view-application', [$jobId,$appId])
        ->with('success','Marked complete.');
}

public function decideApplication(Request $request, $id)
{
    $application = JobApplication::findOrFail($id);

    $request->validate([
        'status' => 'required|in:Accepted,Rejected'
    ]);

    $application->update(['status' => $request->status]);

    $application->student->notify(new ApplicationDecision($application));

    return back()->with('success', 'Application status updated and student notified.');
}
}
