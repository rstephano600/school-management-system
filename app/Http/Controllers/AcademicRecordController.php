<?php

namespace App\Http\Controllers;

use App\Models\AcademicRecord;
use App\Models\Student;
use App\Models\AcademicYear;
use App\Models\Semester;
use App\Models\Classes;
use App\Models\Subject;
use Illuminate\Http\Request;

class AcademicRecordController extends Controller
{
    public function index()
    {
        $schoolId = auth()->user()->school_id;
        $records = AcademicRecord::with(['student', 'year', 'semester', 'class', 'subject'])
                    ->where('school_id', $schoolId)
                    ->orderByDesc('created_at')
                    ->paginate(20);

        return view('in.school.academic_records.index', compact('records'));
    }

    public function create()
    {
        $schoolId = auth()->user()->school_id;
        return view('in.school.academic_records.create', [
            'students' => Student::where('school_id', $schoolId)->get(),
            'academicYears' => AcademicYear::where('school_id', $schoolId)->get(),
            'semesters' => Semester::where('school_id', $schoolId)->get(),
            'classes' => Classes::where('school_id', $schoolId)->get(),
            'subjects' => Subject::where('school_id', $schoolId)->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,user_id',
            'academic_year_id' => 'required|exists:academic_years,id',
            'semester_id' => 'nullable|exists:semesters,id',
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subject,id',
            'average_exam_score' => 'nullable|numeric',
            'average_assignment_score' => 'nullable|numeric',
            'final_score' => 'nullable|numeric',
            'final_grade' => 'nullable|string|max:5',
            'remarks' => 'nullable|string',
        ]);

        $validated['school_id'] = auth()->user()->school_id;

        AcademicRecord::create($validated);

        return redirect()->route('academic-records.index')->with('success', 'Academic record added successfully.');
    }

    public function show(AcademicRecord $academicRecord)
    {
        return view('in.school.academic_records.show', compact('academicRecord'));
    }

    public function edit(AcademicRecord $academicRecord)
    {
        $schoolId = auth()->user()->school_id;

        return view('in.school.academic_records.edit', [
            'academicRecord' => $academicRecord,
            'students' => Student::where('school_id', $schoolId)->get(),
            'academicYears' => AcademicYear::where('school_id', $schoolId)->get(),
            'semesters' => Semester::where('school_id', $schoolId)->get(),
            'classes' => Classes::where('school_id', $schoolId)->get(),
            'subjects' => Subject::where('school_id', $schoolId)->get(),
        ]);
    }

    public function update(Request $request, AcademicRecord $academicRecord)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,user_id',
            'academic_year_id' => 'required|exists:academic_years,id',
            'semester_id' => 'nullable|exists:semesters,id',
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subject,id',
            'average_exam_score' => 'nullable|numeric',
            'average_assignment_score' => 'nullable|numeric',
            'final_score' => 'nullable|numeric',
            'final_grade' => 'nullable|string|max:5',
            'remarks' => 'nullable|string',
        ]);

        $academicRecord->update($validated);

        return redirect()->route('academic-records.index')->with('success', 'Record updated successfully.');
    }

    public function destroy(AcademicRecord $academicRecord)
    {
        $academicRecord->delete();
        return redirect()->route('academic-records.index')->with('success', 'Record deleted.');
    }

    // Optional: report view
    public function reports()
    {
        return view('in.school.academic_records.reports');
    }
}
