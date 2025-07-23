<?php

namespace App\Http\Controllers\teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Classes;
use App\Models\Student;

class TeacherController extends Controller
{
    public function myclasses()
    {
        $teacherId = Auth::id(); // Authenticated teacher's ID

        $classes = Classes::with(['subject', 'grade', 'section', 'room', 'academicYear'])
            ->where('teacher_id', $teacherId)
            ->get();

        return view('in.teacher.classes.myclass', compact('classes'));
    }


public function myStudents()
{
    $teacherId = Auth::id();

    // Get grade IDs of the teacher's classes
    $gradeIds = Classes::where('teacher_id', $teacherId)
                ->pluck('grade_id')
                ->unique();

    // Fetch students whose current_class_id matches any of the grade IDs
    $students = Student::whereIn('grade_id', $gradeIds)
                ->with(['user']) // If students are related to users
                ->get();

    return view('in.teacher.students.index', compact('students'));
}


}
