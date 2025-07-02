<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Subject;
use App\Models\GradeLevel;
use App\Models\Section;
use App\Models\Room;
use App\Models\User;
use App\Models\AcademicYear;
use Illuminate\Http\Request;

class ClassesController extends Controller
{
public function index(Request $request)
{
    $query = Classes::with(['subject', 'grade', 'section', 'teacher', 'room', 'academicYear'])
        ->where('school_id', auth()->user()->school_id);

    if ($request->filled('academic_year_id')) {
        $query->where('academic_year_id', $request->academic_year_id);
    }

    if ($request->filled('grade_id')) {
        $query->where('grade_id', $request->grade_id);
    }

    $classes = $query->paginate(20)->appends($request->query());

    $years = AcademicYear::where('school_id', auth()->user()->school_id)->get();
    $grades = GradeLevel::where('school_id', auth()->user()->school_id)->get();

    return view('in.school.classes.index', compact('classes', 'years', 'grades'));
}

public function create()
{
    $schoolId = auth()->user()->school_id;

    $teachers = \App\Models\Teacher::with('user')
        ->where('school_id', $schoolId)
        ->where('status', true)
        ->get();

    return view('in.school.classes.create', [
        'subjects' => Subject::where('school_id', $schoolId)->get(),
        'grades'   => GradeLevel::where('school_id', $schoolId)->get(),
        'sections' => Section::where('school_id', $schoolId)->get(),
        'teachers' => $teachers,
        'rooms'    => Room::where('school_id', $schoolId)->get(),
        'years'    => AcademicYear::where('school_id', $schoolId)->get(),
    ]);
}


public function store(Request $request)
{
    $validated = $request->validate([
        'subject_id'        => 'required|exists:subject,id',
        'grade_id'          => 'required|exists:grade_levels,id',
        'section_id'        => 'required|exists:sections,id',
        'teacher_id'        => 'required|exists:teachers,user_id',
        'academic_year_id'  => 'required|exists:academic_years,id',
    ]);

    // Get room and capacity from section's assigned room
    $section = \App\Models\Section::with('room')->findOrFail($validated['section_id']);
    $roomId = $section->room_id;
    $capacity = $section->room ? $section->room->capacity : 40; // fallback if no room

    Classes::create([
        'school_id'          => auth()->user()->school_id,
        'academic_year_id'   => $validated['academic_year_id'],
        'subject_id'         => $validated['subject_id'],
        'grade_id'           => $validated['grade_id'],
        'section_id'         => $validated['section_id'],
        'teacher_id'         => $validated['teacher_id'],
        'room_id'            => $roomId,
        'max_capacity'       => $capacity,
        'current_enrollment' => 0,
        'status'             => true,
    ]);

    return redirect()->route('classes.index')->with('success', 'Class scheduled successfully.');
}

public function show(Classes $class)
{
    if ($class->school_id !== auth()->user()->school_id) abort(403);

    $class->load(['subject', 'grade', 'section', 'teacher', 'room', 'academicYear']);
    return view('in.school.classes.show', compact('class'));
}

    public function edit(Classes $class)
    {
        if ($class->school_id !== auth()->user()->school_id) abort(403);

        $schoolId = auth()->user()->school_id;

        return view('in.school.classes.edit', [
            'class'    => $class,
            'subjects' => Subject::where('school_id', $schoolId)->get(),
            'grades'   => GradeLevel::where('school_id', $schoolId)->get(),
            'sections' => Section::where('school_id', $schoolId)->get(),
            'teachers' => User::where('school_id', $schoolId)->where('role', 'teacher')->get(),
            'rooms'    => Room::where('school_id', $schoolId)->get(),
            'years'    => AcademicYear::where('school_id', $schoolId)->get(),
        ]);
    }

    public function update(Request $request, Classes $class)
    {
        if ($class->school_id !== auth()->user()->school_id) abort(403);

        $validated = $request->validate([
            'subject_id'        => 'required|exists:subject,id',
            'grade_id'          => 'required|exists:grade_levels,id',
            'section_id'        => 'required|exists:sections,id',
            'teacher_id' => 'required|exists:teachers,user_id',
            'academic_year_id'  => 'required|exists:academic_years,id',
            'room_id'           => 'nullable|exists:room,id',
            'class_days'        => 'nullable|array',
            'start_time'        => 'required',
            'end_time'          => 'required|after:start_time',
            'max_capacity'      => 'required|integer|min:1',
        ]);

        $class->update($validated);

        return redirect()->route('classes.index')->with('success', 'Class updated.');
    }

    public function destroy(Classes $class)
    {
        if ($class->school_id !== auth()->user()->school_id) abort(403);
        $class->delete();

        return redirect()->route('classes.index')->with('success', 'Class deleted.');
    }



public function timetable()
{
    $classes = Classes::with(['subject', 'section', 'teacher'])
        ->where('school_id', auth()->user()->school_id)
        ->get();

    return view('in.school.classes.timetable', compact('classes'));
}


}
