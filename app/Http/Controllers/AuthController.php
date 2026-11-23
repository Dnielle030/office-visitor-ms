<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'string', 'max:255'],
        ]);

        $key = Str::lower($credentials['email']).'|'.$request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            throw ValidationException::withMessages([
                'email' => "Too many failed attempts. Try again in {$seconds} seconds.",
            ]);
        }

        // is_active = true blocks deactivated staff accounts
        if (Auth::attempt($credentials + ['is_active' => true])) {
            RateLimiter::clear($key);
            $request->session()->regenerate(); // prevents session fixation
            ActivityLog::record('login', 'Logged in');

            return redirect()->intended(route('dashboard'));
        }

        RateLimiter::hit($key, 60);
        ActivityLog::record('login_failed', 'Failed login attempt for '.$credentials['email']);

        throw ValidationException::withMessages(['email' => 'Incorrect email or password.']);
    }

    public function logout(Request $request)
    {
        ActivityLog::record('logout', 'Logged out');

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
