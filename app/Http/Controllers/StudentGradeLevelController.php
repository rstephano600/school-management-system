<?php

namespace App\Http\Controllers;


use App\Models\Student;
use App\Models\GradeLevel;
use App\Models\AcademicYear;
use App\Models\StudentGradeLevel;
use Illuminate\Http\Request;

class StudentGradeLevelController extends Controller
{
    /**
     * Show current grade level + history.
     */
public function index(Request $request, $studentId)
{
    $student = Student::with('user')->where('user_id', $studentId)->firstOrFail();

    $grades = StudentGradeLevel::with(['grade', 'academicYear'])
        ->where('student_id', $studentId)
        ->when($request->filled('search'), function ($q) use ($request) {
            $q->whereHas('grade', fn($g) =>
                $g->where('name', 'like', '%' . $request->search . '%')
            )
            ->orWhereHas('academicYear', fn($y) =>
                $y->where('name', 'like', '%' . $request->search . '%')
            );
        })
        ->orderByDesc('start_date')
        ->paginate(10);

    return view('in.school.gradelevels.index', compact('student', 'grades'));
}


    /**
     * Show promotion form.
     */
    public function create($studentId)
    {
        $student = Student::with('user')->where('user_id', $studentId)->firstOrFail();
        $grades = GradeLevel::where('school_id', $student->school_id)->get();
        $years = AcademicYear::where('school_id', $student->school_id)->get();

        return view('in.school.gradelevels.promote', compact('student', 'grades', 'years'));
    }

    /**
     * Promote student to new grade.
     */
    public function store(Request $request, $studentId)
    {
        $request->validate([
            'grade_level_id' => 'required|exists:grade_levels,id',
            'academic_year_id' => 'required|exists:academic_years,id',
        ]);

        // Deactivate current grade
        StudentGradeLevel::where('student_id', $studentId)
            ->where('is_current', true)
            ->update([
                'is_current' => false,
                'end_date' => now()
            ]);

        // Add new grade record
        StudentGradeLevel::create([
            'student_id' => $studentId,
            'grade_level_id' => $request->grade_level_id,
            'academic_year_id' => $request->academic_year_id,
            'start_date' => now(),
            'is_current' => true,
            'changed_by' => auth()->id()
        ]);

        return redirect()->route('students.show', $studentId)
                         ->with('success', 'Student promoted successfully.');
    }

    /**
     * Optional: Mark student as graduated.
     */
    public function graduate($studentId)
    {
        StudentGradeLevel::where('student_id', $studentId)
            ->where('is_current', true)
            ->update([
                'is_current' => false,
                'end_date' => now()
            ]);

        Student::where('user_id', $studentId)->update(['status' => 'graduated']);

        return redirect()->route('students.show', $studentId)
                         ->with('success', 'Student marked as graduated.');
    }
}
