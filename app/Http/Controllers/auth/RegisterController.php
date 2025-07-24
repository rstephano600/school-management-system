<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\School;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function showRegistrationForm()
{
    $schools = School::all();
    return view('auth.register', compact('schools'));
}

    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:50'],
            // Email validation: required, valid format, lowercase, unique in users table
    'email' => [
        'required',
        'string',
        'lowercase',
        'email:rfc,dns',
        'max:255',
        'unique:users,email',
    ],
            // Password validation: required, at least 8 characters, mix of letters, numbers, symbols
    'password' => [
        'required',
        'string',
        Password::min(8)
            ->mixedCase()     // at least one uppercase and one lowercase
            ->letters()       // at least one letter
            ->numbers()       // at least one number
            ->symbols()       // at least one symbol
            ->uncompromised(), // not found in known data leaks
    ],

            'school_id' => ['required', 'exists:schools,id'],
            // 'role' => ['required'],
            // 'tenant_id' => ['required'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
            'school_id' => $request['school_id'],
            // 'tenant_id' => $request->tenant_id,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect('/register')->with('success', 'Registeted Please Login now');
    }
}
