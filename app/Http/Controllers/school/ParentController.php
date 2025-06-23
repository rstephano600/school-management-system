<?php

namespace App\Http\Controllers\school;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Parents;
use App\Models\User;
use App\Models\Student;
use App\Models\School;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class ParentController extends Controller
{
    public function index()
    {
        $parents = Parents::with(['user', 'school', 'student'])
            ->where('school_id', auth()->user()->school_id)
            ->get();

        return view('in.school.parents.index', compact('parents'));
    }

    // Add other CRUD methods as needed


    /**
     * Show the form for creating a new resource.
     */

      public function create(Student $student)
{
    return view('in.school.parents.create', compact('student'));
}

public function store(Request $request, Student $student)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'occupation' => 'nullable|string',
        'education' => 'nullable|string',
        'annual_income' => 'nullable|numeric',
        'relation_type' => 'required|string',
        'company' => 'nullable|string',
    ]);

    // 1. Create user account for the parent
    $user = User::create([
        'school_id' => $student->school_id,
        'name' => $request->name,
        'email' => $request->email,
        'role' => 'parent',
        'password' => Hash::make('12345678'),
    ]);

    // 2. Create the parent record linked to student
    Parents::create([
        'user_id' => $user->id,
        'school_id' => $student->school_id,
        'student_id' => $student->user_id,
        'occupation' => $request->occupation,
        'education' => $request->education,
        'annual_income' => $request->annual_income,
        'relation_type' => $request->relation_type,
        'company' => $request->company,
    ]);

    return redirect()->route('students.show', $student->user_id)->with('success', 'Parent information saved successfully.');
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
public function edit(Student $student, User $user)
{
    $parent = Parents::where('user_id', $user->id)->where('student_id', $student->user_id)->firstOrFail();
    return view('in.school.parents.edit', compact('student', 'parent', 'user'));
}


    /**
     * Update the specified resource in storage.
     */
public function update(Request $request, Student $student, User $user)
{
    $request->validate([
        'occupation' => 'nullable|string',
        'education' => 'nullable|string',
        'annual_income' => 'nullable|numeric',
        'relation_type' => [
            'required', 'string',
            Rule::unique('parents')->where(function ($q) use ($student, $user) {
                return $q->where('student_id', $student->user_id)->where('user_id', '!=', $user->id);
            }),
        ],
        'company' => 'nullable|string',
    ]);

    $parent = Parents::where('user_id', $user->id)->where('student_id', $student->user_id)->firstOrFail();

    $parent->update($request->only([
        'occupation', 'education', 'annual_income', 'relation_type', 'company'
    ]));

    return redirect()->route('students.show', $student->user_id)->with('success', 'Parent updated.');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
