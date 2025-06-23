<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Timetable;
use App\Models\Classes;
use Carbon\Carbon;

class TimetableController extends Controller
{
    public function index()
{
    $schoolId = auth()->user()->school_id;
    $timetables = Timetable::with(['teacher.user', 'room', 'class'])
        ->where('school_id', $schoolId)
        ->orderBy('day_of_week')
        ->orderBy('period_number')
        ->paginate(20);

    return view('in.school.timetables.index', compact('timetables'));
}

public function create()
{
    $schoolId = auth()->user()->school_id;

    return view('in.school.timetables.create', [
        'classes' => \App\Models\Classes::where('school_id', $schoolId)->get(),
        'teachers' => \App\Models\Teacher::with('user')->where('school_id', $schoolId)->get(),
        'rooms' => \App\Models\Room::where('school_id', $schoolId)->get(),
        'years' => \App\Models\AcademicYear::where('school_id', $schoolId)->get(),
    ]);
}

public function store(Request $request)
{
    $schoolId = auth()->user()->school_id;

    $validated = $request->validate([
        'class_id' => 'required|exists:classes,id',
        'teacher_id' => 'required|exists:teachers,user_id',
        'room_id' => 'nullable|exists:room,id',
        'day_of_week' => 'required|integer|min:1|max:7',
        'period_number' => 'required|integer|min:1',
        'start_time' => 'required|date_format:H:i',
        'end_time' => 'required|date_format:H:i|after:start_time',
        'academic_year_id' => 'required|exists:academic_years,id',
        'effective_from' => 'required|date',
        'effective_to' => 'required|date|after_or_equal:effective_from',
    ]);

    $validated['school_id'] = $schoolId;
    $validated['status'] = $request->has('status');

    Timetable::create($validated);

    return redirect()->route('timetables.index')->with('success', 'Slot added to timetable.');
}

public function edit(Timetable $timetable)
{
    if ($timetable->school_id !== auth()->user()->school_id) abort(403);

    return view('in.school.timetables.edit', [
        'timetable' => $timetable,
        'classes' => \App\Models\Classes::where('school_id', $timetable->school_id)->get(),
        'teachers' => \App\Models\Teacher::with('user')->where('school_id', $timetable->school_id)->get(),
        'rooms' => \App\Models\Room::where('school_id', $timetable->school_id)->get(),
        'years' => \App\Models\AcademicYear::where('school_id', $timetable->school_id)->get(),
    ]);
}

public function update(Request $request, Timetable $timetable)
{
    if ($timetable->school_id !== auth()->user()->school_id) abort(403);

    $validated = $request->validate([
        'class_id' => 'required|exists:classes,id',
        'teacher_id' => 'required|exists:teachers,user_id',
        'room_id' => 'nullable|exists:room,id',
        'day_of_week' => 'required|integer|min:1|max:7',
        'period_number' => 'required|integer|min:1',
        'start_time' => 'required|date_format:H:i',
        'end_time' => 'required|date_format:H:i|after:start_time',
        'academic_year_id' => 'required|exists:academic_years,id',
        'effective_from' => 'required|date',
        'effective_to' => 'required|date|after_or_equal:effective_from',
    ]);

    $validated['status'] = $request->has('status');

    $timetable->update($validated);

    return redirect()->route('timetables.index')->with('success', 'Timetable updated.');
}

public function destroy(Timetable $timetable)
{
    if ($timetable->school_id !== auth()->user()->school_id) abort(403);

    $timetable->delete();

    return redirect()->route('timetables.index')->with('success', 'Slot removed.');
}

}
