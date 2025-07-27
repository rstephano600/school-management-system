<?php

namespace App\Http\Controllers;

use App\Models\ExamResult;
use App\Models\Student;
use App\Models\Exam;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudentAllExaminationController extends Controller
{


    public function index(Request $request)
    {
        $user = Auth::user();
        $schoolId = $user->school_id;

        // Build the query with school authentication
        $query = ExamResult::with(['student.user', 'exam', 'school'])
            ->where('school_id', $schoolId)
            ->where('published', true);

        // Apply filters
        if ($request->filled('student_id')) {
            $query->where('student_id', $request->student_id);
        }

        if ($request->filled('exam_id')) {
            $query->where('exam_id', $request->exam_id);
        }

        if ($request->filled('academic_year_id')) {
            $query->whereHas('exam', function($q) use ($request) {
                $q->where('academic_year_id', $request->academic_year_id);
            });
        }

        if ($request->filled('semester_id')) {
            $query->whereHas('exam', function($q) use ($request) {
                $q->where('semester_id', $request->semester_id);
            });
        }

        if ($request->filled('grade_id')) {
            $query->whereHas('exam', function($q) use ($request) {
                $q->where('grade_id', $request->grade_id);
            });
        }

        if ($request->filled('exam_type_id')) {
            $query->whereHas('exam', function($q) use ($request) {
                $q->where('exam_type_id', $request->exam_type_id);
            });
        }

        if ($request->filled('subject_id')) {
            $query->whereHas('exam', function($q) use ($request) {
                $q->where('subject_id', $request->subject_id);
            });
        }

        if ($request->filled('grade')) {
            $query->where('grade', $request->grade);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('student.user', function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        // Get results with pagination
        $results = $query->orderBy('created_at', 'desc')->paginate(10);

        // Get filter data for dropdowns
        $students = Student::whereHas('user', function($q) use ($schoolId) {
            $q->where('school_id', $schoolId);
        })->with('user')->get();

        $exams = Exam::where('school_id', $schoolId)
            ->with(['academicYear', 'semester', 'examType', 'grade', 'subject'])
            ->get();
        
        $academicYears = \App\Models\AcademicYear::where('school_id', $schoolId)->get();
        
        $semesters = \App\Models\Semester::where('school_id', $schoolId)->get();
        
        $gradeLevels = \App\Models\GradeLevel::where('school_id', $schoolId)->get();
        
        $examTypes = \App\Models\ExamType::where('school_id', $schoolId)->get();

        $subjects = \App\Models\Subject::where('school_id', $schoolId)->get();

        $grades = ['A+', 'A', 'B+', 'B', 'C+', 'C', 'D+', 'D', 'F'];

        return view('in.school.student-examinations.index', compact(
            'results', 
            'students', 
            'exams', 
            'academicYears', 
            'semesters', 
            'gradeLevels', 
            'examTypes', 
            'subjects',
            'grades'
        ));
    }

    public function show($id)
    {
        $user = Auth::user();
        $schoolId = $user->school_id;

        $result = ExamResult::with(['student.user', 'exam', 'school', 'publisher.user'])
            ->where('school_id', $schoolId)
            ->where('published', true)
            ->findOrFail($id);

        return view('in.school.student-examinations.show', compact('result'));
    }

    public function export(Request $request)
    {
        $user = Auth::user();
        $schoolId = $user->school_id;

        $query = ExamResult::with(['student.user', 'exam'])
            ->where('school_id', $schoolId)
            ->where('published', true);

        // Apply same filters as index method
        if ($request->filled('student_id')) {
            $query->where('student_id', $request->student_id);
        }

        if ($request->filled('exam_id')) {
            $query->where('exam_id', $request->exam_id);
        }

        if ($request->filled('academic_year_id')) {
            $query->whereHas('exam', function($q) use ($request) {
                $q->where('academic_year_id', $request->academic_year_id);
            });
        }

        if ($request->filled('semester_id')) {
            $query->whereHas('exam', function($q) use ($request) {
                $q->where('semester_id', $request->semester_id);
            });
        }

        if ($request->filled('grade_id')) {
            $query->whereHas('exam', function($q) use ($request) {
                $q->where('grade_id', $request->grade_id);
            });
        }

        if ($request->filled('exam_type_id')) {
            $query->whereHas('exam', function($q) use ($request) {
                $q->where('exam_type_id', $request->exam_type_id);
            });
        }

        if ($request->filled('subject_id')) {
            $query->whereHas('exam', function($q) use ($request) {
                $q->where('subject_id', $request->subject_id);
            });
        }

        if ($request->filled('grade')) {
            $query->where('grade', $request->grade);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('student.user', function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        $results = $query->get();

        $filename = 'student_examination_results_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($results) {
            $file = fopen('php://output', 'w');
            
            // CSV Headers
            fputcsv($file, [
                'Student Name',
                'Student Email',
                'Exam Title',
                'Academic Year',
                'Semester',
                'Grade Level',
                'Subject',
                'Exam Type',
                'Total Marks',
                'Marks Obtained',
                'Grade',
                'Status',
                'Remarks',
                'Published At'
            ]);

            foreach ($results as $result) {
                fputcsv($file, [
                    $result->student->user->name ?? 'N/A',
                    $result->student->user->email ?? 'N/A',
                    $result->exam->title ?? 'N/A',
                    $result->exam->academicYear->name ?? 'N/A',
                    $result->exam->semester->name ?? 'N/A',
                    $result->exam->grade->name ?? 'N/A',
                    $result->exam->subject->name ?? 'N/A',
                    $result->exam->examType->name ?? 'N/A',
                    $result->exam->total_marks ?? 'N/A',
                    $result->marks_obtained,
                    $result->grade,
                    $result->marks_obtained >= ($result->exam->passing_marks ?? 300) ? 'Pass' : 'Fail',
                    $result->remarks ?? '',
                    $result->published_at ? $result->published_at->format('Y-m-d H:i:s') : ''
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function analytics(Request $request)
    {
        $user = Auth::user();
        $schoolId = $user->school_id;

        $query = ExamResult::where('school_id', $schoolId)
            ->where('published', true);

        // Apply filters
        if ($request->filled('exam_id')) {
            $query->where('exam_id', $request->exam_id);
        }

        if ($request->filled('academic_year_id')) {
            $query->whereHas('exam', function($q) use ($request) {
                $q->where('academic_year_id', $request->academic_year_id);
            });
        }

        $results = $query->get();

        $analytics = [
            'total_results' => $results->count(),
            'pass_count' => $results->where('marks_obtained', '>=', 300)->count(),
            'fail_count' => $results->where('marks_obtained', '<', 300)->count(),
            'average_marks' => $results->avg('marks_obtained'),
            'highest_marks' => $results->max('marks_obtained'),
            'lowest_marks' => $results->min('marks_obtained'),
            'grade_distribution' => $results->countBy('grade'),
        ];

        $analytics['pass_percentage'] = $analytics['total_results'] > 0 
            ? round(($analytics['pass_count'] / $analytics['total_results']) * 100, 2) 
            : 0;

        return response()->json($analytics);
    }
}