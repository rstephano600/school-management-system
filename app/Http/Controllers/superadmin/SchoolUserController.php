<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\School;
use App\Models\User;

class SchoolUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    public function list()
    {
        $users = User::with('school')->get();
        return view('in.superadmin.schools.user-list', compact('users'));
    }

    public function create(School $school)
    {
        return view('in.superadmin.schools.register-user', compact('school'));
    }

    public function store(Request $request, School $school)
    {
        $request->validate([
            'email' => 'required|email|unique:users',
            'role' => 'required|in:student,parent,teacher,super_admin,school_admin,academic_master',
            'name' => 'required',
        ]);

        $user = new User();
        $user->email = $request->email;
        $user->role = $request->role;
        $user->name = $request->name;
        $user->password = Hash::make($request->password);
        $user->school_id = $school->id;
        $user->save();

        return redirect()->route('superadmin.schools.show', $school)
                         ->with('success', 'User registered successfully under ' . $school->name);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

