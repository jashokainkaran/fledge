<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\AllowedStudent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
{
    
                      // 1) Validate, including ensuring the student_id exists & is unregistered
        $request->validate([
            'first_name' => ['required','string','max:255'],
            'last_name'  => ['required','string','max:255'],
            'email'      => ['required','email','max:255','unique:students,email'],
            'student_id' => [
                'required',
                'max:50',
                Rule::exists('allowed_students', 'student_id')->where('is_registered', 0),
            ],
            'password'   => ['required','confirmed', Password::defaults()],
        ]);

        // 2) Fetch the “allowed” record that’s still unregistered
        $allowed = AllowedStudent::where('student_id', $request->student_id)
                                 ->where('is_registered', 0)
                                 ->firstOrFail();

        // 3) Create the new Student
        $student = Student::create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'student_id' => $request->student_id,
            'password'   => Hash::make($request->password),
        ]);

        // 4) Mark them as registered
        $allowed->update(['is_registered' => 1]);

        // 5) Log the student in and redirect
        Auth::guard('web')->login($student);
        $request->session()->regenerate();

        return redirect()->route('student.dashboard')
                         ->with('success', 'Welcome aboard!');
    

    // 6) Mark allowed_students record
    $allowed->update(['is_registered' => true]);
    // 6a) Find the allowed student record (by whatever key makes sense)
$allowed = AllowedStudent::where('student_id', $request->student_id)->firstOrFail();

// 6b) Mark them as registered
$allowed->update(['is_registered' => true]);

    // 7) Log the student in
    Auth::guard('web')->login($student);

    // 7a) Regenerate the session
    $request->session()->regenerate();

    // 8) Redirect to dashboard
    return redirect()->route('student.dashboard')
                     ->with('success', 'Registration successful!');
}
}
