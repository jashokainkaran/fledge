<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\AuthenticationException;



class EmployerLoginController extends Controller
{

    // public function loginEmployer(Request $request)
    // {
    //     $credentials = $request->only('email', 'password');
    
    //     if (Auth::guard('employer')->attempt($credentials)) {
    //         $request->session()->regenerate();
    //         return redirect()->intended(route('employer.dashboard'));
    //     }
    
    //     return back()->withErrors([
    //         'email' => 'The provided credentials do not match our records.',
    //     ]);
    // }

    public function loginEmployer(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (Auth::guard('employer')->attempt($credentials)) {
        // Authentication passed...
        return redirect()->route('employer.dashboard');
    }

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ])->withInput();
}
    


    public function showLoginForm()
    {
        return view('auth.login-employer'); // Make sure this view exists
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['message' => $exception->getMessage()], 401);
        }

        // Check if the guard is 'employer' and redirect accordingly
        $guard = $exception->guards()[0] ?? null;

        switch ($guard) {
            case 'employer':
                $login = route('login-employer');
                break;
            default:
                $login = route('login');
                break;
        }

        return redirect()->guest($login);
    }
}
