<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Http\Request;

class StaffController extends Controller
{

    public function index(Request $request, School $school)
    {
        $schoolId = auth()->user()->school_id;

        $staffMembers = Staff::where('school_id', $schoolId)
                           ->with('user')
                           ->get();

        return view('in.school.staff.index', compact('school', 'staffMembers'));
    }


    // Show: Display staff details

        public function show(School $school, $id)
    {
        $staff = Staff::with('user')->findOrFail($id);

        return view('in.school.staff.show', compact('school', 'staff'));
    }

    // Create: Show form to add new staff
    public function create(School $school)
    {
        return view('in.school.staff.create', compact('school'));
    }

    // Store: Save new staff
    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'school_id' => 'required|exists:schools,id',
        'employee_id' => 'required|string|max:50',
        'joining_date' => 'required|date',
        'designation' => 'nullable|string|max:100',
        'department' => 'nullable|string|max:100',
        'qualification' => 'nullable|string|max:255',
        'experience' => 'nullable|string|max:255',
        'status' => 'required|boolean',
    ]);

    // 1️⃣ Create the user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt('12345678'), // default password
            'role' => 'staff',
            'school_id' => auth()->user()->school_id,
        ]);

    // 2️⃣ Create the staff record
    $staff = Staff::create([
        'user_id' => $user->id,
        'school_id' => $request->school_id,
        'employee_id' => $request->employee_id,
        'joining_date' => $request->joining_date,
        'designation' => $request->designation,
        'department' => $request->department,
        'qualification' => $request->qualification,
        'experience' => $request->experience,
        'status' => $request->status,
    ]);

    return redirect()->route('schools.staff.index')
                     ->with('success', 'Staff member created successfully.');
}


    // Edit: Show form to edit staff
    public function edit(School $school, Staff $staff)
    {
        return view('in.school.staff.edit', compact('school', 'staff'));
    }

    // Update: Update staff details
    public function update(Request $request, School $school, Staff $staff)
    {
        $validated = $request->validate([
            'employee_id' => 'required|string|max:50',
            'joining_date' => 'required|date',
            'designation' => 'required|string|max:100',
            'department' => 'nullable|string|max:100',
            'qualification' => 'nullable|string|max:100',
            'experience' => 'nullable|string|max:100',
            'status' => 'required|boolean',
        ]);

        $staff->update($validated);

        return redirect()->route('schools.staff.index', $school->id)
            ->with('success', 'Staff member updated successfully.');
    }

    // Destroy: Delete staff
    public function destroy(School $school, Staff $staff)
    {
        try {
            $staff->delete();
            return redirect()->route('schools.staff.index', $school->id)
                ->with('success', 'Staff member deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('schools.staff.index', $school->id)
                ->with('error', 'An error occurred while deleting the staff member.');
        }
    }
}
