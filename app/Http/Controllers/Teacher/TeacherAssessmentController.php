<?php

namespace App\Http\Controllers\teacher;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Assessment;
use App\Models\Classes;
use App\Models\Semester;
use App\Models\AcademicYear;

class TeacherAssessmentController extends Controller
{
    public function create()
    {
        $teacherId = Auth::id();

        // Get all unique grade levels and subjects for the teacher
        $teacherClasses = Classes::where('teacher_id', $teacherId)->get();

        $gradeLevels = $teacherClasses->pluck('grade')->unique('id');
        $subjects    = $teacherClasses->pluck('subject')->unique('id');
        $academicYears = $teacherClasses->pluck('academicYear')->unique('id');

        return view('in.teacher.assessments.create', compact('gradeLevels', 'subjects', 'academicYears'));
    }

public function store(Request $request)
{
    $request->validate([
        'title'             => 'required|string|max:255',
        'type'              => 'required|string',
        'grade_level_id'    => 'required|exists:grade_levels,id',
        'subject_id'        => 'required|exists:subjects,id',
        'academic_year_id'  => 'required|exists:academic_years,id',
        'semester_id'       => 'required|exists:semesters,id',
        'due_date'          => 'required|date',
        'attachment'        => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        'description'       => 'nullable|string',
    ]);

    $data = $request->only([
        'school_id', 'title', 'type', 'grade_level_id',
        'subject_id', 'academic_year_id', 'semester_id',
        'due_date', 'description'
    ]);

    $data['school_id'] = Auth::user()->school_id;

    if ($request->hasFile('attachment')) {
        $file = $request->file('attachment');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('attachments', $filename, 'public');
        $data['attachment'] = $path;
    }

    Assessment::create($data);

    return redirect()->route('teacher.assessments.index')->with('success', 'Assessment created.');
}

    public function getSemesters(Request $request)
    {
        $semesters = Semester::where('academic_year_id', $request->academic_year_id)->get();

        return response()->json($semesters);
    }
}

