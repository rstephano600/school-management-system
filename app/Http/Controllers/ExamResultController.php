<?php

namespace App\Http\Controllers;

use App\Models\ExamResult;
use App\Models\AcademicYear;
use App\Models\Semester;
use App\Models\ExamType;
use App\Models\GradeLevel;
use App\Models\Subject;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExamResultsExport;

class ExamResultController extends Controller
{
    /**
     * Display examination results with filtering and search
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $schoolId = $user->school_id;

        // Get filter options
        $academicYears = AcademicYear::where('school_id', $schoolId)
            ->orderBy('start_date', 'desc')
            ->get();

        $semesters = collect();
        $examTypes = ExamType::where('school_id', $schoolId)->get();
        $gradeLevels = GradeLevel::where('school_id', $schoolId)->get();
        $subjects = Subject::where('school_id', $schoolId)->get();

        // Get semesters based on selected academic year
        if ($request->filled('academic_year_id')) {
            $semesters = Semester::where('academic_year_id', $request->academic_year_id)
                ->orderBy('start_date')
                ->get();
        }

        // Build query for exam results
        $query = ExamResult::with([
            'student.user',
            'student.grade',
            'student.section',
            'exam.academicYear',
            'exam.semester',
            'exam.examType',
            'exam.grade',
            'exam.subject',
            'publisher.user'
        ])
        ->whereHas('student', function($q) use ($schoolId) {
            $q->where('school_id', $schoolId);
        })
        ->where('published', true);

        // Apply filters
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

        if ($request->filled('exam_type_id')) {
            $query->whereHas('exam', function($q) use ($request) {
                $q->where('exam_type_id', $request->exam_type_id);
            });
        }

        if ($request->filled('grade_id')) {
            $query->whereHas('exam', function($q) use ($request) {
                $q->where('grade_id', $request->grade_id);
            });
        }

        if ($request->filled('subject_id')) {
            $query->whereHas('exam', function($q) use ($request) {
                $q->where('subject_id', $request->subject_id);
            });
        }

        // Search by student name or admission number
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->whereHas('student', function($q) use ($searchTerm) {
                $q->where('admission_number', 'like', "%{$searchTerm}%")
                  ->orWhere('fname', 'like', "%{$searchTerm}%")
                  ->orWhere('mname', 'like', "%{$searchTerm}%")
                  ->orWhere('lname', 'like', "%{$searchTerm}%")
                  ->orWhereRaw("CONCAT(fname, ' ', COALESCE(mname, ''), ' ', lname) LIKE ?", ["%{$searchTerm}%"]);
            });
        }

        // Get results with pagination
        $results = $query->orderBy('created_at', 'desc')->paginate(50);

        // Calculate statistics
        $statistics = $this->calculateStatistics($query->clone());

        return view('in.school.exam-results.index', compact(
            'results',
            'academicYears',
            'semesters',
            'examTypes',
            'gradeLevels',
            'subjects',
            'statistics'
        ));
    }

    /**
     * Get semesters for selected academic year (AJAX)
     */
    public function getSemesters(Request $request)
    {
        $semesters = Semester::where('academic_year_id', $request->academic_year_id)
            ->orderBy('start_date')
            ->get(['id', 'name']);

        return response()->json($semesters);
    }

    /**
     * Export exam results
     */
    public function export(Request $request)
    {
        $format = $request->input('format', 'excel');
        $user = Auth::user();
        $schoolId = $user->school_id;

        // Build the same query as index method
        $query = ExamResult::with([
            'student.user',
            'student.grade',
            'student.section',
            'exam.academicYear',
            'exam.semester',
            'exam.examType',
            'exam.grade',
            'exam.subject',
            'publisher.user'
        ])
        ->whereHas('student', function($q) use ($schoolId) {
            $q->where('school_id', $schoolId);
        })
        ->where('published', true);

        // Apply the same filters
        $this->applyFilters($query, $request);

        $results = $query->orderBy('created_at', 'desc')->get();

        $fileName = 'exam_results_' . now()->format('Y_m_d_H_i_s');

        switch ($format) {
            case 'pdf':
                return $this->exportToPdf($results, $fileName);
            case 'csv':
                return $this->exportToCsv($results, $fileName);
            case 'excel':
            default:
                return $this->exportToExcel($results, $fileName);
        }
    }

    /**
     * Export to Excel
     */
    private function exportToExcel($results, $fileName)
    {
        return Excel::download(new ExamResultsExport($results), $fileName . '.xlsx');
    }

    /**
     * Export to CSV
     */
    private function exportToCsv($results, $fileName)
    {
        return Excel::download(new ExamResultsExport($results), $fileName . '.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    /**
     * Export to PDF
     */
    private function exportToPdf($results, $fileName)
    {
        $pdf = Pdf::loadView('in.school.exam-results.pdf', compact('results'));
        return $pdf->download($fileName . '.pdf');
    }

    /**
     * Apply filters to query
     */
    private function applyFilters($query, $request)
    {
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

        if ($request->filled('exam_type_id')) {
            $query->whereHas('exam', function($q) use ($request) {
                $q->where('exam_type_id', $request->exam_type_id);
            });
        }

        if ($request->filled('grade_id')) {
            $query->whereHas('exam', function($q) use ($request) {
                $q->where('grade_id', $request->grade_id);
            });
        }

        if ($request->filled('subject_id')) {
            $query->whereHas('exam', function($q) use ($request) {
                $q->where('subject_id', $request->subject_id);
            });
        }

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->whereHas('student', function($q) use ($searchTerm) {
                $q->where('admission_number', 'like', "%{$searchTerm}%")
                  ->orWhere('fname', 'like', "%{$searchTerm}%")
                  ->orWhere('mname', 'like', "%{$searchTerm}%")
                  ->orWhere('lname', 'like', "%{$searchTerm}%")
                  ->orWhereRaw("CONCAT(fname, ' ', COALESCE(mname, ''), ' ', lname) LIKE ?", ["%{$searchTerm}%"]);
            });
        }
    }

    /**
     * Calculate statistics for the current filter
     */
    private function calculateStatistics($query)
    {
        $results = $query->get();
        
        return [
            'total_students' => $results->count(),
            'total_exams' => $results->pluck('exam_id')->unique()->count(),
            'average_marks' => $results->avg('marks_obtained'),
            'highest_marks' => $results->max('marks_obtained'),
            'lowest_marks' => $results->min('marks_obtained'),
            'pass_rate' => $results->count() > 0 ? 
                ($results->where('grade', '!=', 'F')->count() / $results->count()) * 100 : 0
        ];
    }

    /**
     * Show individual student result
     */
    public function show($id)
    {
        $result = ExamResult::with([
            'student.user',
            'student.grade',
            'student.section',
            'exam.academicYear',
            'exam.semester',
            'exam.examType',
            'exam.grade',
            'exam.subject',
            'publisher.user'
        ])->findOrFail($id);

        // Check if user has permission to view this result
        if ($result->student->school_id !== Auth::user()->school_id) {
            abort(403, 'Unauthorized access to exam result.');
        }

        return view('in.school.exam-results.show', compact('result'));
    }

    /**
     * Get student exam history
     */
    public function studentHistory($studentId)
    {
        $student = Student::where('user_id', $studentId)
            ->where('school_id', Auth::user()->school_id)
            ->firstOrFail();

        $results = ExamResult::with([
            'exam.academicYear',
            'exam.semester',
            'exam.examType',
            'exam.subject'
        ])
        ->where('student_id', $studentId)
        ->where('published', true)
        ->orderBy('created_at', 'desc')
        ->paginate(20);

        return view('in.school.exam-results.student-history', compact('student', 'results'));
    }








    public function generalResults(Request $request)
{
    $user = auth()->user();
    $schoolId = $user->school_id;

    $query = ExamResult::with(['student.user', 'exam.subject', 'exam.examType', 'exam.academicYear', 'exam.semester'])
        ->where('school_id', $schoolId);

    if ($request->filled('grade_id')) {
        $query->whereHas('exam', fn($q) => $q->where('grade_id', $request->grade_id));
    }

    if ($request->filled('academic_year_id')) {
        $query->whereHas('exam', fn($q) => $q->where('academic_year_id', $request->academic_year_id));
    }

    if ($request->filled('semester_id')) {
        $query->whereHas('exam', fn($q) => $q->where('semester_id', $request->semester_id));
    }
    if ($request->filled('exam_type_id')) {
        $query->whereHas('exam', fn($q) => $q->where('exam_type_id', $request->exam_type_id));
    }

    if ($request->filled('subject_id')) {
        $query->whereHas('exam', fn($q) => $q->where('subject_id', $request->subject_id));
    }

    $results = $query->orderByDesc('created_at')->paginate(25);

    $academicYears = \App\Models\AcademicYear::where('school_id', $schoolId)->latest()->get();
    $subjects = \App\Models\Subject::where('school_id', $schoolId)->get();
    $grades = \App\Models\GradeLevel::where('school_id', $schoolId)->get();
    $semesters = \App\Models\Semester::where('school_id', $schoolId)->get();
    $examTypes = \App\Models\ExamType::where('school_id', $schoolId)->get();

    return view('in.school.exams.results.general', compact('results', 'academicYears', 'subjects', 'grades', 'semesters', 'examTypes'));
}


    private function authorizeAccess(ExamResult $result)
    {
        if ($result->school_id !== auth()->user()->school_id && auth()->user()->role !== 'superadmin') {
            abort(403);
        }
    }


    public function showImportForm(Exam $exam)
    {
        // Optional: Check access here
        return view('in.school.exams.results.import', compact('exam'));
    }



public function print(Request $request)
{
    $results = $this->getFilteredResults($request)->get(); // no pagination
    return view('in.school.exams.results.print', compact('results'));
}


public function exportExcel(Request $request)
{
    $results = $this->getFilteredResults($request)->get(); // no pagination

    return Excel::download(new GeneralExamResultsExport($results), 'general_exam_results.xlsx');
}


public function import(Request $request, Exam $exam)
{
    $request->validate([
        'excel_file' => 'required|file|mimes:xlsx,xls,csv',
    ]);

    $import = new ExamResultsImport($exam->id);
    Excel::import($import, $request->file('excel_file'));

    if (!empty($import->errors)) {
        return redirect()->back()
            ->with('error', 'Some rows were not imported due to errors.')
            ->with('importErrors', $import->errors);
    }

    return redirect()->route('exam-results.index')->with('success', 'Exam results imported successfully.');
}



}