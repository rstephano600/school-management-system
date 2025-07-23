<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use App\Models\School;
use App\Models\GradeLevel;
use App\Models\Section;
use Illuminate\Http\Request;
use App\Models\StudentGradeLevel;
use Illuminate\Validation\Rule;

class StudentsController extends Controller
{


    public function index()
    {
        $students = Student::with(['user', 'school', 'grade', 'section'])
            ->orderBy('admission_number')
            ->paginate(20);

        return view('students.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::whereDoesntHave('student')->get();
        $schools = School::all();
        $grades = GradeLevel::all();
        $sections = Section::all();

        return view('students.create', compact('users', 'schools', 'grades', 'sections'));
    }

    /**
     * Store a newly created resource in storage.
     */

public function store(Request $request)
{
    $validated = $request->validate([
        // New user fields
        'email' => 'required|email|unique:users,email',
        // 'password' => '12345678',

        // Student fields
        'admitted_by' => 'required|exists:users,id',
        'school_id' => 'required|exists:schools,id',
        'admission_number' => 'required|string|max:50|unique:students',
        'fname' => 'required|string|max:100',
        'mname' => 'required|string|max:100',
        'lname' => 'required|string|max:100',
        'admission_date' => 'required|date',
        'grade_id' => 'nullable|exists:grade_levels,id',
        'section_id' => 'nullable|exists:sections,id',
        'roll_number' => 'nullable|string|max:20',
        'date_of_birth' => 'required|date',
        'gender' => 'required|in:M,F,O',
        'blood_group' => 'nullable|string|max:5',
        'religion' => 'nullable|string|max:50',
        'nationality' => 'nullable|string|max:50',
        'is_transport' => 'boolean',
        'is_hostel' => 'boolean',
        'status' => ['required', Rule::in(['active', 'graduated', 'transferred'])],
        'previous_school_info' => 'nullable|json',
    ]);

    $fullName = trim("{$request->fname} {$request->mname} {$request->lname}");
    $password = strtoupper($validated['lname']); // Capitalize last name

    // Step 1: Create the user
    $user = User::create([
        'name' => $fullName,
        'email' => $validated['email'],
        'password' => Hash::make($password),
        'role' => 'student',
        'school_id' => $validated['school_id'],
    ]);

    // Step 2: Create the student
    $student = Student::create(array_merge($validated, ['user_id' => $user->id]));

    // Step 3: Log grade level
    if ($request->filled('grade_id')) {
        $currentAcademicYear = \App\Models\AcademicYear::where('school_id', $student->school_id)
            ->where('is_current', true)
            ->first();

        if ($currentAcademicYear) {
            StudentGradeLevel::create([
                'student_id' => $user->id,
                'grade_level_id' => $request->grade_id,
                'academic_year_id' => $currentAcademicYear->id,
                'start_date' => $student->admission_date,
                'is_current' => true,
                'changed_by' => auth()->id(),
            ]);
        }
    }

    return redirect()->route('students.show', $student->user_id)
        ->with('success', 'Student account and grade level created successfully.' );
}


    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        $student->load(['user', 'school', 'grade', 'section', 'admittedBy']);

        return view('students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        $schools = School::all();
        $grades = GradeLevel::all();
        $sections = Section::all();

        return view('students.edit', compact('student', 'schools', 'grades', 'sections'));
    }

    /**
     * Update the specified resource in storage.
     */
public function update(Request $request, Student $student)
{
    $validated = $request->validate([
        'school_id' => 'required|exists:schools,id',
        'admission_number' => 'required|string|max:50|unique:students,admission_number,' . $student->user_id . ',user_id',
        'admission_date' => 'required|date',
        'grade_id' => 'nullable|exists:grade_levels,id',
        'section_id' => 'nullable|exists:sections,id',
        'roll_number' => 'nullable|string|max:20',
        'date_of_birth' => 'required|date',
        'gender' => 'required|in:M,F,O',
        'blood_group' => 'nullable|string|max:5',
        'religion' => 'nullable|string|max:50',
        'nationality' => 'nullable|string|max:50',
        'is_transport' => 'boolean',
        'is_hostel' => 'boolean',
        'status' => ['required', Rule::in(['active', 'graduated', 'transferred'])],
        'previous_school_info' => 'nullable|json',
    ]);

    $gradeChanged = $request->grade_id && $request->grade_id != $student->grade_id;

    // ✅ Only update the student model
    $student->update($validated);

    // ✅ Track grade change
    if ($gradeChanged) {
        \App\Models\StudentGradeLevel::where('student_id', $student->user_id)
            ->where('is_current', true)
            ->update([
                'is_current' => false,
                'end_date' => now(),
            ]);

        $currentAcademicYear = \App\Models\AcademicYear::where('school_id', $student->school_id)
            ->where('is_current', true)
            ->first();

        if ($currentAcademicYear) {
            \App\Models\StudentGradeLevel::create([
                'student_id' => $student->user_id,
                'grade_level_id' => $request->grade_id,
                'academic_year_id' => $currentAcademicYear->id,
                'start_date' => now(),
                'is_current' => true,
                'changed_by' => auth()->id(),
            ]);
        }
    }

    return redirect()->route('students.show', $student->user_id)
        ->with('success', 'Student updated successfully.');
}



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()->route('students.index')
            ->with('success', 'Student deleted successfully.');
    }











    
public function updateeee(Request $request, Student $student)
{
    $validated = $request->validate([
        // Update user info
        'name' => 'required|string|max:100',
        'email' => 'required|email|unique:users,email,' . $student->user_id,
        'password' => 'nullable|string|min:6',

        // Update student info
        'school_id' => 'required|exists:schools,id',
        'admission_number' => 'required|string|max:50|unique:students,admission_number,' . $student->user_id . ',user_id',
        'admission_date' => 'required|date',
        'grade_id' => 'nullable|exists:grade_levels,id',
        'section_id' => 'nullable|exists:sections,id',
        'roll_number' => 'nullable|string|max:20',
        'date_of_birth' => 'required|date',
        'gender' => 'required|in:M,F,O',
        'blood_group' => 'nullable|string|max:5',
        'religion' => 'nullable|string|max:50',
        'nationality' => 'nullable|string|max:50',
        'is_transport' => 'boolean',
        'is_hostel' => 'boolean',
        'status' => ['required', Rule::in(['active', 'graduated', 'transferred'])],
        'previous_school_info' => 'nullable|json',
    ]);

    // Step 1: Update related user
    $student->user->update([
        'name' => $validated['name'],
        'email' => $validated['email'],
        // Only update password if filled
        'password' => $request->filled('password') ? Hash::make($request->password) : $student->user->password,
    ]);

    // Step 2: Check if the grade is being changed
    $gradeChanged = $request->grade_id && $request->grade_id != $student->grade_id;

    // Step 3: Update student info
    $student->update($validated);

    if ($gradeChanged) {
        // Close previous grade record
        StudentGradeLevel::where('student_id', $student->user_id)
            ->where('is_current', true)
            ->update([
                'is_current' => false,
                'end_date' => now()
            ]);

        // Create new grade record
        $currentAcademicYear = AcademicYear::where('school_id', $student->school_id)
            ->where('is_current', true)
            ->first();

        if ($currentAcademicYear) {
            StudentGradeLevel::create([
                'student_id' => $student->user_id,
                'grade_level_id' => $request->grade_id,
                'academic_year_id' => $currentAcademicYear->id,
                'start_date' => now(),
                'is_current' => true,
                'changed_by' => auth()->id(),
            ]);
        }
    }

    return redirect()->route('students.show', $student->user_id)
        ->with('success', 'Student and account updated successfully.');
}

}