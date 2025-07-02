<?php

namespace App\Http\Controllers;

use App\Models\TestTimetable;
use App\Models\AcademicYear;
use App\Models\Classes;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;

class TestTimetableController extends Controller
{
    public function index()
    {
        $schoolId = auth()->user()->school_id;
        $tests = TestTimetable::where('school_id', $schoolId)->with(['class', 'subject', 'teacher'])->get();
        return view('in.school.tests.timetable.index', compact('tests'));
    }

    public function create()
    {
        $years = AcademicYear::all();
        $classes = Classes::all();
        $subjects = Subject::all();
        $teachers = Teacher::with('user')->get();
        return view('in.school.tests.timetable.create', compact('years', 'classes', 'subjects', 'teachers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'academic_year_id' => 'required|exists:academic_years,id',
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subject,id',
            'teacher_id' => 'required|exists:teachers,user_id',
            'test_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        TestTimetable::create([
            'school_id' => auth()->user()->school_id,
            'academic_year_id' => $request->academic_year_id,
            'class_id' => $request->class_id,
            'subject_id' => $request->subject_id,
            'teacher_id' => $request->teacher_id,
            'test_date' => $request->test_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->has('status'),
        ]);

        return redirect()->route('tests.index')->with('success', 'Test schedule created.');
    }

    public function edit(TestTimetable $test)
    {
        $years = AcademicYear::all();
        $classes = Classes::all();
        $subjects = Subject::all();
        $teachers = Teacher::with('user')->get();
        return view('in.school.tests.timetable.edit', compact('test', 'years', 'classes', 'subjects', 'teachers'));
    }

    public function update(Request $request, TestTimetable $test)
    {
        $request->validate([
            'academic_year_id' => 'required|exists:academic_years,id',
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subject,id',
            'teacher_id' => 'required|exists:teachers,user_id',
            'test_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $test->update([
            'academic_year_id' => $request->academic_year_id,
            'class_id' => $request->class_id,
            'subject_id' => $request->subject_id,
            'teacher_id' => $request->teacher_id,
            'test_date' => $request->test_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->has('status'),
        ]);

        return redirect()->route('tests.index')->with('success', 'Test schedule updated.');
    }

    public function destroy(TestTimetable $test)
    {
        $test->delete();
        return redirect()->route('tests.index')->with('success', 'Test deleted.');
    }
}
