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

    // Attempt authentication
    if (Auth::attempt($credentials)) {
        $user = Auth::user();

        // Check if user account is active
        if ($user->status !== 'active') {
            Auth::logout();
            
            $statusMessage = match($user->status) {
                'inactive' => 'Your account is currently inactive. Please contact the administrator.',
                'suspended' => 'Your account has been suspended. Please contact the administrator.',
                'pending' => 'Your account is pending approval. Please wait for administrator approval.',
                'blocked' => 'Your account has been blocked. Please contact the administrator.',
                default => 'Your account status does not allow login. Please contact the administrator.'
            };

            return back()->withErrors([
                'email' => $statusMessage,
            ])->onlyInput('email');
        }

        // Check if user has a valid role
        if (empty($user->role)) {
            Auth::logout();
            return back()->withErrors([
                'email' => 'No role assigned to your account. Please contact the administrator.',
            ])->onlyInput('email');
        }

        // Regenerate session for security
        $request->session()->regenerate();

        // Log successful login (optional)
        \Log::info('User logged in', [
            'user_id' => $user->id,
            'email' => $user->email,
            'role' => $user->role,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        // Role-based redirection
        switch ($user->role) {
            case 'super_admin':
                return redirect()->route('superadmin.dashboard');
            case 'school_admin':
                return redirect()->route('schooladmin.dashboard');
            case 'school_creator':
                return redirect()->route('schoolcreator.dashboard');
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
            case 'school_librarian': // Fixed typo
                return redirect()->route('schoollibrarian.dashboard');
            case 'parent':
                return redirect()->route('parent.dashboard');
            case 'student':
                return redirect()->route('student.dashboard');
            default:
                // Log suspicious activity
                \Log::warning('User with unknown role attempted login', [
                    'user_id' => $user->id,
                    'role' => $user->role,
                    'email' => $user->email
                ]);
                
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Invalid user role. Please contact the administrator.',
                ])->onlyInput('email');
        }
    }

    // Authentication failed
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