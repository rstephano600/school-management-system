<?php

namespace App\Services;

use App\Models\Timetable;
use App\Models\TestTimetable;
use App\Models\ExamTimetable;
use App\Models\SchoolGeneralSchedule;
use Illuminate\Support\Facades\Auth;
use PDF;


class ScheduleService
{
    protected $schoolId;

    public function __construct()
    {
        $this->schoolId = Auth::user()->school_id;
    }

    public function getClassSessions()
    {
        return Timetable::with([
            'teacher.user', 'room', 'class'
        ])
            ->where('school_id', $this->schoolId)
            ->get();
    }


    public function getTests()
    {
        return TestTimetable::with([
                'class', 'subject', 'teacher.user'
            ])
            ->where('school_id', $this->schoolId)
            ->get();
    }

    public function getExams()
    {
        return ExamTimetable::with([
                'class', 'subject', 'teacher.user'
            ])
            ->where('school_id', $this->schoolId)
            ->get();
    }

    public function getGeneralActivities()
    {
        return SchoolGeneralSchedule::where('school_id', $this->schoolId)->get();
    }

    public function getAll()
    {
        return [
            'sessions' => $this->getClassSessions(),
            
            'tests'    => $this->getTests(),
            'exams'    => $this->getExams(),
            'general'  => $this->getGeneralActivities(),
        ];
        dd($sessions->take(3));

    }




public function generateWeeklyPdf(array $filters = [])
{
    $sessions = $this->getClassSessions();
    $tests    = $this->getTests();
    $exams    = $this->getExams();
    $general  = $this->getGeneralActivities();

    // Apply optional filters
    if (!empty($filters['academic_year_id'])) {
        $sessions = $sessions->where('academic_year_id', $filters['academic_year_id']);
        $tests    = $tests->where('academic_year_id', $filters['academic_year_id']);
        $exams    = $exams->where('academic_year_id', $filters['academic_year_id']);
        $general  = $general->where('academic_year_id', $filters['academic_year_id']);
    }

    if (!empty($filters['class_id'])) {
        $sessions = $sessions->where('class_id', $filters['class_id']);
        $tests    = $tests->where('class_id', $filters['class_id']);
        $exams    = $exams->where('class_id', $filters['class_id']);
    }

    $academicYears = \App\Models\AcademicYear::all();
    $classes = \App\Models\Classes::all();

    $pdf = PDF::loadView('in.school.calendar.pdf', compact(
        'sessions', 'tests', 'exams', 'general', 'academicYears', 'classes'
    ));

    return $pdf->download('weekly_calendar.pdf');
}

}
