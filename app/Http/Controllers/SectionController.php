<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\Room;
use App\Models\GradeLevel;
use App\Models\Teacher;
use App\Models\AcademicYear;
use Illuminate\Http\Request;

class SectionController extends Controller
{
public function index(Request $request)
{
    $schoolId = auth()->user()->school_id;

    $query = Section::with('grade', 'teacher.user', 'room', 'academicYear')
        ->where('school_id', $schoolId);

    if ($request->filled('academic_year_id')) {
        $query->where('academic_year_id', $request->academic_year_id);
    }

    if ($request->filled('grade_id')) {
        $query->where('grade_id', $request->grade_id);
    }

    $sections = $query->paginate(20)->appends($request->query());

    $grades = \App\Models\GradeLevel::where('school_id', $schoolId)->get();
    $years = \App\Models\AcademicYear::where('school_id', $schoolId)->get();

    return view('in.school.sections.index', compact('sections', 'grades', 'years'));
}


    public function create()
    {
        $schoolId = auth()->user()->school_id;

        return view('in.school.sections.create', [
            'grades' => GradeLevel::where('school_id', $schoolId)->get(),
            'rooms' => Room::where('school_id', $schoolId)->get(),
            'teachers' => Teacher::with('user')->where('school_id', $schoolId)->get(),
            'years' => AcademicYear::where('school_id', $schoolId)->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:10',
            'code' => 'required|string|max:10|unique:sections,code',
            'grade_id' => 'required|exists:grade_levels,id',
            'capacity' => 'required|integer|min:1',
            'room_id' => 'nullable|exists:room,id',
            'class_teacher_id' => 'nullable|exists:teachers,user_id',
            'academic_year_id' => 'required|exists:academic_years,id',
            'status' => 'boolean',
        ]);

        Section::create(array_merge($validated, [
            'school_id' => auth()->user()->school_id,
            'user_id' => auth()->id(),
            'status' => $request->has('status'),
        ]));

        return redirect()->route('sections.index')->with('success', 'Section created.');
    }
public function show(Section $section)
{
    if ($section->school_id !== auth()->user()->school_id) {
        abort(403);
    }

    $section->load(['grade', 'room', 'teacher.user', 'academicYear']);
    return view('in.school.sections.show', compact('section'));
}

    public function edit(Section $section)
    {
        if ($section->school_id !== auth()->user()->school_id) abort(403);

        $schoolId = auth()->user()->school_id;

        return view('in.school.sections.edit', [
            'section' => $section,
            'grades' => GradeLevel::where('school_id', $schoolId)->get(),
            'rooms' => Room::where('school_id', $schoolId)->get(),
            'teachers' => Teacher::with('user')->where('school_id', $schoolId)->get(),
            'years' => AcademicYear::where('school_id', $schoolId)->get(),
        ]);
    }

    public function update(Request $request, Section $section)
    {
        if ($section->school_id !== auth()->user()->school_id) abort(403);

        $validated = $request->validate([
            'name' => 'required|string|max:10',
            'code' => 'required|string|max:10|unique:sections,code,' . $section->id,
            'grade_id' => 'required|exists:grade_levels,id',
            'capacity' => 'required|integer|min:1',
            'room_id' => 'nullable|exists:room,id',
            'class_teacher_id' => 'nullable|exists:teachers,user_id',
            'academic_year_id' => 'required|exists:academic_years,id',
            'status' => 'boolean',
        ]);

        $section->update(array_merge($validated, [
            'status' => $request->has('status'),
        ]));

        return redirect()->route('sections.index')->with('success', 'Section updated.');
    }

    public function destroy(Section $section)
    {
        if ($section->school_id !== auth()->user()->school_id) abort(403);
        $section->delete();
        return redirect()->route('sections.index')->with('success', 'Section deleted.');
    }
}
