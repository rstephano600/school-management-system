<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ScheduleService;

class CalendarController extends Controller
{
    public function siimplifiedWeeklyView()
{
    $schoolId = auth()->user()->school_id;

    // Class sessions (from timetables)
    $sessions = \App\Models\Timetable::with([
        'teacher.user',
        'class.subject',
        'class.section'
    ])
    ->where('school_id', $schoolId)
    ->orderBy('day_of_week')
    ->orderBy('start_time')
    ->get();


    // General school activities
    $general = \App\Models\SchoolGeneralSchedule::where('school_id', $schoolId)->get();

    // Tests & exams
    $tests = \App\Models\TestTimetable::where('school_id', $schoolId)->get();
    $exams = \App\Models\ExamTimetable::where('school_id', $schoolId)->get();

    return view('in.school.calendar.simple', compact('sessions', 'general', 'tests', 'exams'));
}


public function simplifiedWeeklyView(Request $request, ScheduleService $scheduleService)
{
    $data = $scheduleService->getAll();

    $academicYears = \App\Models\AcademicYear::all();
    $classes = \App\Models\Classes::all();

    return view('in.school.calendar.simple', [
        'sessions' => $data['sessions'],
        'tests'    => $data['tests'],
        'exams'    => $data['exams'],
        'general'  => $data['general'],
        'academicYears' => $academicYears,
        'classes' => $classes
    ]);
}


public function exportPdf(Request $request, ScheduleService $scheduleService)
{
    $filters = $request->only('academic_year_id', 'class_id');
    return $scheduleService->generateWeeklyPdf($filters);
}




}
