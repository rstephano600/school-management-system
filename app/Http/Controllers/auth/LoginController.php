<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle login submission and redirect based on user role.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            switch ($user->role) {
                case 'super_admin':
                    return redirect()->route('superadmin.dashboard');
                case 'school_admin':
                    return redirect()->route('schooladmin.dashboard');
                case 'director':
                    return redirect()->route('director.dashboard');
                case 'manager':
                    return redirect()->route('manager.dashboard');
                case 'head_master':
                    return redirect()->route('headmaster.dashboard');
                case 'secretary':
                    return redirect()->route('secretary.dashboard');
                case 'academic_master':
                    return redirect()->route('academicmaster.dashboard');
                case 'teacher':
                    return redirect()->route('teacher.dashboard');
                case 'staff':
                    return redirect()->route('staff.dashboard');
                case 'school_doctor':
                    return redirect()->route('schooldoctor.dashboard');
                case 'school_libralian':
                    return redirect()->route('schoollibralian.dashboard');
                case 'parent':
                    return redirect()->route('parent.dashboard');
                case 'student':
                    return redirect()->route('student.dashboard');
                default:
                    return redirect()->route('user.dashboard');
            }
        }
        // auth()->user()->school_id;

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Log the user out and invalidate the session.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
