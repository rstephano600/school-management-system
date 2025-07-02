<?php

namespace App\Http\Controllers;

use App\Models\SchoolGeneralSchedule;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GeneralScheduleController extends Controller
{
    public function index()
    {
        $schoolId = Auth::user()->school_id;

        $schedules = SchoolGeneralSchedule::where('school_id', $schoolId)
            ->orderByRaw("FIELD(day_of_week, 'Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday')")
            ->orderBy('start_time')
            ->get()
            ->groupBy('day_of_week');

        return view('in.school.general_schedule.index', compact('schedules'));
    }

    public function create()
    {
        $academicYears = AcademicYear::all();
        return view('in.school.general_schedule.create', compact('academicYears'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'academic_year_id' => 'required|exists:academic_years,id',
            'day_of_week' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'activity' => 'required|string|max:255',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'description' => 'nullable|string',
        ]);

        SchoolGeneralSchedule::create([
            'school_id' => Auth::user()->school_id,
            'academic_year_id' => $request->academic_year_id,
            'day_of_week' => $request->day_of_week,
            'activity' => $request->activity,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'description' => $request->description,
            'status' => $request->has('status'),
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('general-schedule.index')->with('success', 'Schedule added.');
    }

    public function show(SchoolGeneralSchedule $generalSchedule)
    {
        return view('in.school.general_schedule.show', compact('generalSchedule'));
    }

    public function edit(SchoolGeneralSchedule $generalSchedule)
    {
        $academicYears = AcademicYear::all();
        return view('in.school.general_schedule.edit', compact('generalSchedule', 'academicYears'));
    }

    public function update(Request $request, SchoolGeneralSchedule $generalSchedule)
    {
        $request->validate([
            'academic_year_id' => 'required|exists:academic_years,id',
            'day_of_week' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'activity' => 'required|string|max:255',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'description' => 'nullable|string',
        ]);

        $generalSchedule->update([
            'academic_year_id' => $request->academic_year_id,
            'day_of_week' => $request->day_of_week,
            'activity' => $request->activity,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'description' => $request->description,
            'status' => $request->has('status'),
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('general-schedule.index')->with('success', 'Schedule updated.');
    }

    public function destroy(SchoolGeneralSchedule $generalSchedule)
    {
        $generalSchedule->delete();
        return redirect()->route('general-schedule.index')->with('success', 'Schedule deleted.');
    }
}
