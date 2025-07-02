<?php

namespace App\Http\Controllers;

use App\Models\HolidayTimetable;
use App\Models\AcademicYear;
use Illuminate\Http\Request;

class HolidayTimetableController extends Controller
{
    public function index()
    {
        $holidays = HolidayTimetable::where('school_id', auth()->user()->school_id)->get();
        return view('in.school.holidays.index', compact('holidays'));
    }

    public function create()
    {
        $years = AcademicYear::all();
        return view('in.school.holidays.create', compact('years'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'academic_year_id' => 'required|exists:academic_years,id',
            'name' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'description' => 'nullable|string',
        ]);

        HolidayTimetable::create([
            'school_id' => auth()->user()->school_id,
            'academic_year_id' => $request->academic_year_id,
            'name' => $request->name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'description' => $request->description,
            'status' => $request->has('status'),
        ]);

        return redirect()->route('holidays.index')->with('success', 'Holiday created.');
    }

    public function edit(HolidayTimetable $holiday)
    {
        $years = AcademicYear::all();
        return view('in.school.holidays.edit', compact('holiday', 'years'));
    }

    public function update(Request $request, HolidayTimetable $holiday)
    {
        $request->validate([
            'academic_year_id' => 'required|exists:academic_years,id',
            'name' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'description' => 'nullable|string',
        ]);

        $holiday->update([
            'academic_year_id' => $request->academic_year_id,
            'name' => $request->name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'description' => $request->description,
            'status' => $request->has('status'),
        ]);

        return redirect()->route('holidays.index')->with('success', 'Holiday updated.');
    }

    public function destroy(HolidayTimetable $holiday)
    {
        $holiday->delete();
        return redirect()->route('holidays.index')->with('success', 'Holiday deleted.');
    }
}
