<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Employer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;

class EmployerRegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register-employer'); // blade name is correct
    }

    public function register(Request $request)
{
    $request->validate([
        'company_name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:employers',
        'phone' => 'required|string',
        'password' => 'required|string|min:6|confirmed',
    ]);

    \App\Models\Employer::create([
        'company_name' => $request->company_name,
        'email' => $request->email,
        'phone' => $request->phone,
        'password' => Hash::make($request->password),
    ]);

    return redirect()->route('login-employer')->with('success', 'Registration successful. Please log in.');
}
}
