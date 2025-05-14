<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Job;
use App\Models\Review;
use App\Models\Employer;        // ← import the Employer model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    /**
     * Show the admin login form.
     */
    public function showLoginForm(Request $request)
    {
        $request->session()->forget('_old_input');
        return view('admin.login');
    }

    /**
     * Process the login request.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required','email'],
            'password' => ['required','string'],
        ]);

        if (Auth::guard('admin')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        return back()
            ->withInput($request->only('email','remember'))
            ->withErrors(['login'=>'Invalid credentials']);
    }

    /**
     * Log the admin out.
     */
   public function logout(Request $request)
{
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/admin/login'); // ✅ this should point to your admin login
}

    /**
     * Show the admin dashboard with pending employers.
     */
    public function dashboard()
    {
        // Fetch only the employers whose status is 'pending'
        $pending = Employer::where('status', 'pending')->get();

        // Pass $pending into the dashboard view
        return view('admin.dashboard', compact('pending'));
    }

    /**
     * Delete a job listing.
     */
    public function deleteJob($id)
    {
        $job = Job::findOrFail($id);
        $job->delete();

        return redirect()
            ->route('admin.dashboard')
            ->with('success','Job deleted successfully.');
    }

    /**
     * Show all student reviews in the admin panel.
     */
    public function reviews()
    {
        $reviews = Review::with(['student','application.job.employer'])
                         ->latest()
                         ->paginate(20);

        return view('admin.review.index', compact('reviews'));
    }

    /**
     * Delete one student review.
     */
    public function deleteReview($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return redirect()
            ->route('admin.review.index')
            ->with('success','Review deleted successfully.');
    }
}