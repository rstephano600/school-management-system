<?php

namespace App\Http\Controllers\schooladmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\School;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use App\Models\Behaviour;
use App\Models\Health;
use App\Models\Library;


class SchoolAdmindashboardController extends Controller
{

    public function index()
    {
        $admin = auth()->user();

        if ($admin->role !== 'school_admin') {
            abort(403);
        }

        $schoolId = $admin->school_id;

        return view('in.schooladmin.dashboard', [
            'totalUsers'    => User::where('school_id', $schoolId)->count(),
            'totalStudents' => User::where('school_id', $schoolId)->where('role', 'student')->count(),
            'totalTeachers' => User::where('school_id', $schoolId)->where('role', 'teacher')->count(),
            'totalParents'  => User::where('school_id', $schoolId)->where('role', 'parent')->count(),

            // 'academicInfo'  => Academic::where('school_id', $schoolId)->latest()->take(5)->get(),
            // 'behaviours'    => Behaviour::where('school_id', $schoolId)->latest()->take(5)->get(),
            // 'healthInfo'    => Health::where('school_id', $schoolId)->latest()->take(5)->get(),
            // 'libraryInfo'   => Library::where('school_id', $schoolId)->latest()->take(5)->get(),
        ]);
    }

    public function dashboard()
     {
    $schooladmin = auth()->user();

    if ($schooladmin->role !== 'school_admin') {
            abort(403);
        }

    $schoolId = $schooladmin->school_id;

    // Example: Counting Students, Teachers, and Classes
    $studentCount = Student::where('school_id', $schoolId)->count();
    $teacherCount = Teacher::where('school_id', $schoolId)->count();
    // $classroomCount = Classroom::where('school_id', $schoolId)->count();

    // Example: Fetch all Students
    $students = Student::where('school_id', $schoolId)->get();

    return view('in.schooladmin.dashboard', compact('studentCount', 'teacherCount', 'students'));
    }



}
