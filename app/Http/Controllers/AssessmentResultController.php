<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\AssessmentResult;
use App\Models\Student;
use App\Models\AcademicYear;
use App\Models\Semester;
use App\Models\GradeLevel;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssessmentResultController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Get filter options based on user's school
        $academicYears = AcademicYear::where('school_id', $user->school_id)->get();
        $semesters = Semester::where('school_id', $user->school_id)->get();
        $gradeLevels = GradeLevel::where('school_id', $user->school_id)->get();
        $subjects = Subject::where('school_id', $user->school_id)->get();

        // Build query
        $query = AssessmentResult::with([
            'assessment.gradeLevel',
            'assessment.subject',
            'assessment.academicYear',
            'assessment.semester',
            'student.user',
            'recordedBy'
        ])
        ->whereHas('assessment', function($q) use ($user) {
            $q->where('school_id', $user->school_id);
        });

        // Apply filters
        if ($request->filled('academic_year_id')) {
            $query->whereHas('assessment', function($q) use ($request) {
                $q->where('academic_year_id', $request->academic_year_id);
            });
        }

        if ($request->filled('semester_id')) {
            $query->whereHas('assessment', function($q) use ($request) {
                $q->where('semester_id', $request->semester_id);
            });
        }

        if ($request->filled('grade_level_id')) {
            $query->whereHas('assessment', function($q) use ($request) {
                $q->where('grade_level_id', $request->grade_level_id);
            });
        }

        if ($request->filled('subject_id')) {
            $query->whereHas('assessment', function($q) use ($request) {
                $q->where('subject_id', $request->subject_id);
            });
        }

        // Search by student name or admission number
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('student', function($q) use ($search) {
                $q->where('admission_number', 'LIKE', "%{$search}%")
                  ->orWhere('fname', 'LIKE', "%{$search}%")
                  ->orWhere('mname', 'LIKE', "%{$search}%")
                  ->orWhere('lname', 'LIKE', "%{$search}%")
                  ->orWhereRaw("CONCAT(fname, ' ', COALESCE(mname, ''), ' ', lname) LIKE ?", ["%{$search}%"]);
            });
        }

        // Get results with pagination
        $results = $query->orderBy('created_at', 'desc')->paginate(15);

        // Calculate statistics
        $totalResults = $query->count();
        $averageScore = $query->avg('score');
        $highestScore = $query->max('score');
        $lowestScore = $query->min('score');

        return view('in.school.assessment.result.index', compact(
            'results',
            'academicYears',
            'semesters',
            'gradeLevels',
            'subjects',
            'totalResults',
            'averageScore',
            'highestScore',
            'lowestScore'
        ));
    }

    public function show($id)
    {
        $result = AssessmentResult::with([
            'assessment.gradeLevel',
            'assessment.subject',
            'assessment.academicYear',
            'assessment.semester',
            'student.user',
            'recordedBy'
        ])->findOrFail($id);

        // Check if user has access to this result
        $user = Auth::user();
        if ($result->assessment->school_id !== $user->school_id) {
            abort(403, 'Unauthorized access');
        }

        return view('in.school.assessment.results.show', compact('result'));
    }

    public function export(Request $request)
    {
        // Export functionality can be implemented here
        // This is a placeholder for CSV/Excel export
        return response()->json(['message' => 'Export functionality to be implemented']);
    }
}