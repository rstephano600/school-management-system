<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use App\Models\School;
use App\Models\GradeLevel;
use App\Models\Section;
use Illuminate\Http\Request;
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
            'user_id' => 'required|exists:users,id|unique:students,user_id',
            'admitted_by' => 'required|exists:users,id',
            'school_id' => 'required|exists:schools,id',
            'admission_number' => 'required|string|max:50|unique:students',
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

        $student = Student::create($validated);

        return redirect()->route('students.show', $student->user_id)
            ->with('success', 'Student created successfully.');
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
            'admission_number' => 'required|string|max:50|unique:students,admission_number,'.$student->user_id.',user_id',
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

        $student->update($validated);

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
}