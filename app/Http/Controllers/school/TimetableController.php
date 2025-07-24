<?php

namespace App\Http\Controllers\school;

use App\Http\Controllers\Controller;

use App\Models\Classes;
use App\Models\SchoolGeneralSchedule;
use App\Models\Subject;
use App\Models\GradeLevel;
use App\Models\Section;
use App\Models\Room;
use App\Models\User;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TimetableController extends Controller
{
    public function index(Request $request)
    {
        $timeSlots = $this->generateTimeSlots();
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        
        // Get filter options
        $subjects = Subject::where('school_id', auth()->user()->school_id)->get();
        $grades = GradeLevel::where('school_id', auth()->user()->school_id)->get();
        $sections = Section::where('school_id', auth()->user()->school_id)->get();
        $rooms = Room::where('school_id', auth()->user()->school_id)->get();
        $teachers = User::whereHas('teacher', function($query) {
            $query->where('status', true);
        })->where('school_id', auth()->user()->school_id)->get();
        
        $currentAcademicYear = AcademicYear::where('school_id', auth()->user()->school_id)
            ->where('status', 'active')
            ->first();

        // Build query for classes
        $classesQuery = Classes::with(['subject', 'grade', 'section', 'teacher', 'room'])
            ->where('school_id', auth()->user()->school_id);
            
        if ($currentAcademicYear) {
            $classesQuery->where('academic_year_id', $currentAcademicYear->id);
        }

        // Apply filters
        if ($request->filled('subject_id')) {
            $classesQuery->where('subject_id', $request->subject_id);
        }
        
        if ($request->filled('grade_id')) {
            $classesQuery->where('grade_id', $request->grade_id);
        }
        
        if ($request->filled('section_id')) {
            $classesQuery->where('section_id', $request->section_id);
        }
        
        if ($request->filled('teacher_id')) {
            $classesQuery->where('teacher_id', $request->teacher_id);
        }
        
        if ($request->filled('room_id')) {
            $classesQuery->where('room_id', $request->room_id);
        }

        $classes = $classesQuery->get();

        // Build query for general schedule
        $scheduleQuery = SchoolGeneralSchedule::where('school_id', auth()->user()->school_id);
        
        if ($currentAcademicYear) {
            $scheduleQuery->where('academic_year_id', $currentAcademicYear->id);
        }

        $generalSchedule = $scheduleQuery->get();

        // Organize timetable data
        $timetableData = $this->organizeTimetableData($classes, $generalSchedule, $timeSlots, $days);

        return view('in.school.timetable.index', compact(
            'timetableData', 
            'timeSlots', 
            'days', 
            'subjects', 
            'grades', 
            'sections', 
            'rooms', 
            'teachers',
            'currentAcademicYear'
        ));
    }

    private function generateTimeSlots()
    {
        $timeSlots = [];
        $start = Carbon::createFromTime(7, 30);
        $end = Carbon::createFromTime(20, 30);

        while ($start->lessThanOrEqualTo($end)) {
            $timeSlots[] = $start->format('H:i');
            $start->addMinutes(30);
        }

        return $timeSlots;
    }

    private function organizeTimetableData($classes, $generalSchedule, $timeSlots, $days)
    {
        $timetableData = [];

        // Initialize empty timetable
        foreach ($timeSlots as $time) {
            foreach ($days as $day) {
                $timetableData[$time][$day] = [];
            }
        }

        // Add classes to timetable
        foreach ($classes as $class) {
            if ($class->class_days && $class->start_time && $class->end_time) {
                $startTime = Carbon::parse($class->start_time)->format('H:i');
                $endTime = Carbon::parse($class->end_time)->format('H:i');
                
                foreach ($class->class_days as $day) {
                    $dayName = ucfirst($day);
                    if (in_array($dayName, $days)) {
                        $timetableData[$startTime][$dayName][] = [
                            'type' => 'class',
                            'title' => $class->subject->name ?? 'N/A',
                            'code' => $class->subject->code ?? '',
                            'teacher' => $class->teacher->name ?? 'N/A',
                            'room' => $class->room->name ?? $class->room->number ?? 'N/A',
                            'grade' => $class->grade->name ?? 'N/A',
                            'section' => $class->section->name ?? 'N/A',
                            'start_time' => $startTime,
                            'end_time' => $endTime,
                            'duration' => $this->calculateDuration($startTime, $endTime),
                            'capacity' => $class->max_capacity,
                            'enrollment' => $class->current_enrollment,
                            'status' => $class->status
                        ];
                    }
                }
            }
        }

        // Add general schedule to timetable
        foreach ($generalSchedule as $schedule) {
            $startTime = Carbon::parse($schedule->start_time)->format('H:i');
            $endTime = Carbon::parse($schedule->end_time)->format('H:i');
            $dayName = ucfirst($schedule->day_of_week);
            
            if (in_array($dayName, $days)) {
                $timetableData[$startTime][$dayName][] = [
                    'type' => 'general',
                    'title' => $schedule->activity,
                    'description' => $schedule->description,
                    'start_time' => $startTime,
                    'end_time' => $endTime,
                    'duration' => $this->calculateDuration($startTime, $endTime),
                    'status' => $schedule->status
                ];
            }
        }

        return $timetableData;
    }

    private function calculateDuration($startTime, $endTime)
    {
        $start = Carbon::parse($startTime);
        $end = Carbon::parse($endTime);
        $duration = $start->diffInMinutes($end);
        
        $hours = intval($duration / 60);
        $minutes = $duration % 60;
        
        if ($hours > 0 && $minutes > 0) {
            return "{$hours}h {$minutes}m";
        } elseif ($hours > 0) {
            return "{$hours}h";
        } else {
            return "{$minutes}m";
        }
    }

    public function export(Request $request)
    {
        // Implementation for exporting timetable (PDF, Excel, etc.)
        // This would be similar to the index method but return export format
    }
}