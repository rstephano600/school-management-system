<?php

namespace App\Helpers;

use Carbon\Carbon;
use App\Models\Classes;
use App\Models\SchoolGeneralSchedule;

class TimetableHelper
{
    /**
     * Check for scheduling conflicts
     */
    public static function checkConflicts($schoolId, $teacherId, $roomId, $day, $startTime, $endTime, $excludeClassId = null)
    {
        $conflicts = [];
        
        // Check teacher conflicts
        if ($teacherId) {
            $teacherConflicts = Classes::where('school_id', $schoolId)
                ->where('teacher_id', $teacherId)
                ->whereJsonContains('class_days', strtolower($day))
                ->where(function($query) use ($startTime, $endTime) {
                    $query->whereBetween('start_time', [$startTime, $endTime])
                          ->orWhereBetween('end_time', [$startTime, $endTime])
                          ->orWhere(function($q) use ($startTime, $endTime) {
                              $q->where('start_time', '<=', $startTime)
                                ->where('end_time', '>=', $endTime);
                          });
                });
                
            if ($excludeClassId) {
                $teacherConflicts->where('id', '!=', $excludeClassId);
            }
            
            if ($teacherConflicts->exists()) {
                $conflicts[] = [
                    'type' => 'teacher',
                    'message' => 'Teacher has another class at this time',
                    'details' => $teacherConflicts->with(['subject', 'room'])->get()
                ];
            }
        }
        
        // Check room conflicts
        if ($roomId) {
            $roomConflicts = Classes::where('school_id', $schoolId)
                ->where('room_id', $roomId)
                ->whereJsonContains('class_days', strtolower($day))
                ->where(function($query) use ($startTime, $endTime) {
                    $query->whereBetween('start_time', [$startTime, $endTime])
                          ->orWhereBetween('end_time', [$startTime, $endTime])
                          ->orWhere(function($q) use ($startTime, $endTime) {
                              $q->where('start_time', '<=', $startTime)
                                ->where('end_time', '>=', $endTime);
                          });
                });
                
            if ($excludeClassId) {
                $roomConflicts->where('id', '!=', $excludeClassId);
            }
            
            if ($roomConflicts->exists()) {
                $conflicts[] = [
                    'type' => 'room',
                    'message' => 'Room is already booked at this time',
                    'details' => $roomConflicts->with(['subject', 'teacher'])->get()
                ];
            }
        }
        
        return $conflicts;
    }
    
    /**
     * Get available time slots for a day
     */
    public static function getAvailableTimeSlots($schoolId, $day, $duration = 60)
    {
        $startHour = 7;
        $endHour = 20;
        $slotDuration = $duration; // minutes
        
        $availableSlots = [];
        $bookedSlots = [];
        
        // Get all booked slots for the day
        $classes = Classes::where('school_id', $schoolId)
            ->whereJsonContains('class_days', strtolower($day))
            ->get(['start_time', 'end_time']);
            
        $generalSchedule = SchoolGeneralSchedule::where('school_id', $schoolId)
            ->where('day_of_week', strtolower($day))
            ->get(['start_time', 'end_time']);
        
        // Combine and process booked slots
        foreach ($classes as $class) {
            $bookedSlots[] = [
                'start' => Carbon::parse($class->start_time),
                'end' => Carbon::parse($class->end_time)
            ];
        }
        
        foreach ($generalSchedule as $schedule) {
            $bookedSlots[] = [
                'start' => Carbon::parse($schedule->start_time),
                'end' => Carbon::parse($schedule->end_time)
            ];
        }
        
        // Generate available slots
        $currentTime = Carbon::createFromTime($startHour, 0);
        $endTime = Carbon::createFromTime($endHour, 0);
        
        while ($currentTime->copy()->addMinutes($slotDuration)->lessThanOrEqualTo($endTime)) {
            $slotEnd = $currentTime->copy()->addMinutes($slotDuration);
            $isAvailable = true;
            
            foreach ($bookedSlots as $booked) {
                if ($currentTime->between($booked['start'], $booked['end']) ||
                    $slotEnd->between($booked['start'], $booked['end']) ||
                    ($currentTime->lessThanOrEqualTo($booked['start']) && $slotEnd->greaterThanOrEqualTo($booked['end']))) {
                    $isAvailable = false;
                    break;
                }
            }
            
            if ($isAvailable) {
                $availableSlots[] = [
                    'start' => $currentTime->format('H:i'),
                    'end' => $slotEnd->format('H:i'),
                    'duration' => $slotDuration
                ];
            }
            
            $currentTime->addMinutes(30); // Move in 30-minute increments
        }
        
        return $availableSlots;
    }
    
    /**
     * Calculate workload for a teacher
     */
    public static function getTeacherWorkload($teacherId, $academicYearId = null)
    {
        $query = Classes::where('teacher_id', $teacherId);
        
        if ($academicYearId) {
            $query->where('academic_year_id', $academicYearId);
        }
        
        $classes = $query->get();
        
        $totalHours = 0;
        $totalClasses = $classes->count();
        $subjects = [];
        
        foreach ($classes as $class) {
            $duration = Carbon::parse($class->start_time)->diffInMinutes(Carbon::parse($class->end_time));
            $totalHours += ($duration / 60) * count($class->class_days);
            
            if (!in_array($class->subject_id, $subjects)) {
                $subjects[] = $class->subject_id;
            }
        }
        
        return [
            'total_hours_per_week' => round($totalHours, 2),
            'total_classes' => $totalClasses,
            'unique_subjects' => count($subjects),
            'average_hours_per_class' => $totalClasses > 0 ? round($totalHours / $totalClasses, 2) : 0
        ];
    }
    
    /**
     * Get room utilization statistics
     */
    public static function getRoomUtilization($roomId, $academicYearId = null)
    {
        $query = Classes::where('room_id', $roomId);
        
        if ($academicYearId) {
            $query->where('academic_year_id', $academicYearId);
        }
        
        $classes = $query->get();
        
        $totalHours = 0;
        $utilizationByDay = [];
        
        foreach ($classes as $class) {
            $duration = Carbon::parse($class->start_time)->diffInMinutes(Carbon::parse($class->end_time));
            $totalHours += ($duration / 60) * count($class->class_days);
            
            foreach ($class->class_days as $day) {
                $utilizationByDay[$day] = ($utilizationByDay[$day] ?? 0) + ($duration / 60);
            }
        }
        
        // Assuming 13 hours per day (7:00 AM to 8:00 PM) and 5 working days
        $maxPossibleHours = 13 * 5;
        $utilizationPercentage = ($totalHours / $maxPossibleHours) * 100;
        
        return [
            'total_hours_per_week' => round($totalHours, 2),
            'utilization_percentage' => round($utilizationPercentage, 2),
            'utilization_by_day' => $utilizationByDay,
            'classes_count' => $classes->count()
        ];
    }
    
    /**
     * Export timetable data to array format
     */
    public static function exportTimetableData($schoolId, $academicYearId = null, $filters = [])
    {
        $timetableController = new \App\Http\Controllers\TimetableController();
        
        // This would need to be refactored to use the controller's methods
        // For now, return basic structure
        return [
            'school_info' => [
                'id' => $schoolId,
                'academic_year_id' => $academicYearId
            ],
            'filters_applied' => $filters,
            'export_date' => Carbon::now()->format('Y-m-d H:i:s'),
            'data' => [] // Would contain the actual timetable data
        ];
    }
    
    /**
     * Validate timetable entry
     */
    public static function validateTimetableEntry($data)
    {
        $errors = [];
        
        // Check if start time is before end time
        if (isset($data['start_time']) && isset($data['end_time'])) {
            if (Carbon::parse($data['start_time'])->greaterThanOrEqualTo(Carbon::parse($data['end_time']))) {
                $errors[] = 'Start time must be before end time';
            }
        }
        
        // Check if class days are provided
        if (empty($data['class_days'])) {
            $errors[] = 'At least one class day must be selected';
        }
        
        // Check capacity constraints
        if (isset($data['max_capacity']) && isset($data['current_enrollment'])) {
            if ($data['current_enrollment'] > $data['max_capacity']) {
                $errors[] = 'Current enrollment cannot exceed maximum capacity';
            }
        }
        
        return $errors;
    }
}