<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\EmployerLoginController;
use App\Http\Controllers\Auth\EmployerRegisterController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\StudentJobController;
use App\Http\Controllers\StudentReviewController;
use App\Http\Controllers\EmployerDashboardController;
use App\Http\Controllers\EmployerJobController;
use App\Http\Controllers\AdminEmployerController;

/*
|--------------------------------------------------------------------------
| Global Logout
|--------------------------------------------------------------------------
*/
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    // Student Auth
    Route::get('login',    [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login',   [LoginController::class, 'login']);
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register',[RegisterController::class, 'register']);
// Employer Auth (only for guests)
    Route::get('login-employer',
        [EmployerLoginController::class, 'showLoginForm']
    )->name('login-employer');

    Route::post('login-employer',
        [EmployerLoginController::class, 'loginEmployer']
    )->name('login-employer.submit');

    Route::get('register-employer',
        [EmployerRegisterController::class, 'showRegistrationForm']
    )->name('register-employer');

    Route::post('register-employer',
        [EmployerRegisterController::class, 'register']
    );

    // Admin Auth
    Route::get('admin/login',  [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
});

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/',               [JobController::class, 'home'])->name('home');
Route::get('jobs',            [JobController::class, 'index'])->name('jobs.index');
Route::get('jobs/{job}',      [JobController::class, 'show'])->name('jobs.show');
Route::get('jobs/apply/{id}', [JobController::class, 'apply'])->name('jobs.apply');

Route::get('profile',         [ProfileController::class, 'show'])->name('profile');
Route::put('profile/update',  [ProfileController::class, 'update'])->name('profile.update');

/*
|--------------------------------------------------------------------------
| Student Routes (authenticated)
|--------------------------------------------------------------------------
*/
Route::prefix('student')
     ->name('student.')
     ->middleware('auth')
     ->group(function () {
         // Dashboard
         Route::get('dashboard', [StudentDashboardController::class, 'dashboard'])->name('dashboard');

         // Job application
         Route::get('jobs/{job}/apply',  [StudentJobController::class, 'showApplyForm'])->name('jobs.apply_form');
         Route::post('jobs/{job}/apply', [StudentJobController::class, 'submitApplication'])->name('jobs.submit_application');
         Route::get('apply-job/{id}',    [StudentJobController::class, 'apply'])->name('applied_jobs');

         // Listings
         Route::get('applied-jobs',   [StudentJobController::class, 'applied'])->name('applied_jobs');
         Route::get('completed-jobs', [StudentDashboardController::class, 'completedJobs'])->name('completed_jobs');

         // Reviews
         Route::get('review/{application}',  [StudentReviewController::class, 'create'])->name('review.create');
         Route::post('review/{application}', [StudentReviewController::class, 'store'])->name('review.store');
    });

/*
|--------------------------------------------------------------------------
| Employer Routes (authenticated)
|--------------------------------------------------------------------------
*/
Route::prefix('employer')
     ->name('employer.')
     ->middleware('auth:employer')
     ->group(function () {
         // Dashboard
        Route::get('dashboard', [EmployerDashboardController::class, 'index'])->name('dashboard');
         // Job CRUD
         Route::get('job/create',       [EmployerJobController::class, 'create'])->name('job.create');
         Route::post('job',             [EmployerJobController::class, 'store'])->name('job.store');
         Route::get('job/{job}/edit',   [EmployerJobController::class, 'edit'])->name('job.edit');
         Route::put('job/{job}',        [EmployerJobController::class, 'update'])->name('job.update');
         Route::delete('job/{job}',     [EmployerJobController::class, 'destroy'])->name('job.delete');

         // Applications
         Route::get('job/{job}/applicants',           [EmployerJobController::class, 'applicants'])->name('job.applicants');
         Route::get('job/{job}/application/{app}',    [EmployerJobController::class, 'viewApplication'])->name('job.view_application');
         Route::post('job/{job}/application/{app}/approve', [EmployerJobController::class, 'approveApplication'])->name('job.application.approve');
         Route::delete('job/{job}/application/{app}/reject', [EmployerJobController::class, 'rejectApplication'])->name('job.application.reject');
         Route::get('job/{job}/application/{app}/schedule',  [EmployerJobController::class, 'showScheduleForm'])->name('job.application.schedule_form');
         Route::post('job/{job}/application/{app}/schedule', [EmployerJobController::class, 'scheduleApplication'])->name('job.application.schedule_submit');
         Route::post('job/{job}/application/{app}/complete', [EmployerJobController::class, 'completeApplication'])->name('job.application.complete');

         Route::get('login-employer',  [EmployerLoginController::class, 'showLoginForm'])->name('login-employer');

        Route::post('login-employer', [EmployerLoginController::class, 'loginEmployer'])->name('login-employer.submit');});

/*
|--------------------------------------------------------------------------
| Admin Routes (authenticated as admin)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
     ->name('admin.')
     ->middleware('auth:admin')
     ->group(function () {
         // Dashboard
         Route::get('dashboard', [AdminEmployerController::class, 'dashboard'])->name('dashboard');

         // Manage employers
         Route::get('employers/pending',     [AdminEmployerController::class, 'index'])->name('employer.pending');
         Route::post('employers/{id}/verify', [AdminEmployerController::class, 'verify'])->name('employer.verify');
         Route::post('employers/{id}/reject', [AdminEmployerController::class, 'reject'])->name('employer.reject');

         // Job approvals
         Route::get('jobs/pending',             [AdminEmployerController::class, 'pendingJobs'])->name('jobs.pending');
         Route::post('jobs/{id}/approve',       [AdminEmployerController::class, 'approveJob'])->name('jobs.approve');
         Route::post('jobs/{id}/reject',        [AdminEmployerController::class, 'rejectJob'])->name('jobs.reject');
         Route::delete('jobs/{id}',             [AdminAuthController::class,   'deleteJob'])->name('jobs.delete');

         // Reviews
         Route::get('reviews',      [AdminEmployerController::class, 'showReviews'])->name('review.index');
         Route::delete('reviews/{id}', [AdminEmployerController::class, 'deleteReview'])->name('review.delete');

         // Admin logout
         Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');
    });
