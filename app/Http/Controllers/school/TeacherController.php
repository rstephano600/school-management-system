<?php

namespace App\Http\Controllers\school;

use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::with('user')->where('school_id', auth()->user()->school_id)->paginate(20);
        return view('in.school.teachers.index', compact('teachers'));
    }

    public function create()
    {
        return view('in.school.teachers.create');
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'employee_id' => 'required|string|max:50|unique:teachers,employee_id',
        'joining_date' => 'required|date',
        'qualification' => 'required|string|max:255',
        'specialization' => 'required|string|max:255',
        'experience' => 'required|numeric',
        'department' => 'required|string|max:255',
        'is_class_teacher' => 'boolean',
        'status' => 'boolean',
    ]);

    $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => Hash::make('12345678'), // 🔐 Default password
        'school_id' => auth()->user()->school_id,
        'role' => 'teacher',
    ]);

    Teacher::create([
        'user_id' => $user->id,
        'school_id' => $user->school_id,
        'employee_id' => $validated['employee_id'],
        'joining_date' => $validated['joining_date'],
        'qualification' => $validated['qualification'],
        'specialization' => $validated['specialization'],
        'experience' => $validated['experience'],
        'department' => $validated['department'],
        'is_class_teacher' => $request->has('is_class_teacher'),
        'status' => $request->has('status'),
    ]);

    return redirect()->route('teachers.index')->with('success', 'Teacher created with default password (12345678).');
}


    public function edit($id)
    {
        $teacher = Teacher::with('user')->where('user_id', $id)->firstOrFail();
        return view('in.school.teachers.edit', compact('teacher'));
    }

    public function update(Request $request, $id)
    {
        $teacher = Teacher::where('user_id', $id)->firstOrFail();
        $user = $teacher->user;

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'employee_id' => 'required|string|max:50|unique:teachers,employee_id,' . $id . ',user_id',
            'joining_date' => 'required|date',
            'qualification' => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
            'experience' => 'required|numeric',
            'department' => 'required|string|max:255',
            'is_class_teacher' => 'boolean',
            'status' => 'boolean',
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        $teacher->update([
            'employee_id' => $validated['employee_id'],
            'joining_date' => $validated['joining_date'],
            'qualification' => $validated['qualification'],
            'specialization' => $validated['specialization'],
            'experience' => $validated['experience'],
            'department' => $validated['department'],
            'is_class_teacher' => $request->has('is_class_teacher'),
            'status' => $request->has('status'),
        ]);

        return redirect()->route('teachers.index')->with('success', 'Teacher updated successfully.');
    }

    public function destroy($id)
    {
        $teacher = Teacher::where('user_id', $id)->firstOrFail();
        $teacher->user()->delete(); // deletes both teacher and user
        return redirect()->route('teachers.index')->with('success', 'Teacher deleted.');
    }



}
