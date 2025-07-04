<?php

namespace App\Http\Controllers;

use App\Models\ExamResult;
use App\Models\Exam;
use App\Models\Grade;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Imports\ExamResultsImport;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow; // optional, if you're using headings
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\StudentsImport;
use App\Exports\GeneralExamResultsExport;
use Illuminate\Support\Facades\Auth;

class ExamResultController extends Controller
{
        public function index($examId, Request $request)
{
    $exam = Exam::with(['grade', 'subject'])->findOrFail($examId);

    $students = Student::with('user')
        ->where('school_id', $exam->school_id)
        ->where('grade_id', $exam->grade_id)
        ->when($request->search, function ($q, $search) {
            $q->where('admission_number', 'like', "%{$search}%")
              ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$search}%"));
        })
        ->orderBy('admission_number')
        ->paginate(25);

    $existingResults = ExamResult::where('exam_id', $exam->id)
        ->pluck('marks_obtained', 'student_id');

    return view('in.school.exams.results.index', compact('exam', 'students', 'existingResults'));
}

public function examresult(Exam $exam)
{
    $user = Auth::user();

    // Authorization
    if ($user->role !== 'superadmin' && $user->school_id !== $exam->school_id) {
        abort(403);
    }

    // Fetch exam results with student and user details
    $results = ExamResult::with(['student.user'])
        ->where('exam_id', $exam->id)
        ->orderBy('marks_obtained', 'desc')
        ->paginate(20);

    return view('in.school.exams.results.examresult', compact('exam', 'results'));
}

    public function create()
    {
        $schoolId = auth()->user()->school_id;

        return view('in.school.exams.results.create', [
            'exams' => Exam::where('school_id', $schoolId)->get(),
            'students' => Student::where('school_id', $schoolId)->get(),
        ]);
    }

    
public function store(Request $request, Exam $exam)
{
    $data = $request->input('results', []);

    foreach ($data as $studentId => $score) {
        if ($score === null || $score === '') continue;

        $grade = Grade::where('school_id', $exam->school_id)
            ->where('min_score', '<=', $score)
            ->where('max_score', '>=', $score)
            ->first();

        ExamResult::updateOrCreate(
            ['exam_id' => $exam->id, 'student_id' => $studentId],
            [
                'school_id' => $exam->school_id,
                'marks_obtained' => $score,
                'grade' => $grade->grade_letter ?? 'N/A',
                'remarks' => $grade->remarks ?? null,
            ]
        );
    }

    return back()->with('success', 'Results saved successfully.');
}
    public function show(ExamResult $examResult)
    {
        $this->authorizeAccess($examResult);
        return view('in.school.exams.results.show', compact('examResult'));
    }

    public function edit(ExamResult $examResult)
    {
        $this->authorizeAccess($examResult);

        $schoolId = auth()->user()->school_id;

        return view('in.school.exams.results.edit', [
            'examResult' => $examResult,
            'exams' => Exam::where('school_id', $schoolId)->get(),
            'students' => Student::where('school_id', $schoolId)->get(),
        ]);
    }

    public function update(Request $request, ExamResult $examResult)
    {
        $this->authorizeAccess($examResult);

        $request->validate([
            'marks_obtained' => 'required|numeric|min:0',
            'grade' => 'required|string|max:5',
            'remarks' => 'nullable|string|max:1000',
        ]);

        $examResult->update([
            'marks_obtained' => $request->marks_obtained,
            'grade' => $request->grade,
            'remarks' => $request->remarks,
        ]);

        return redirect()->route('exam-results.index')->with('success', 'Result updated successfully.');
    }

    public function destroy(ExamResult $examResult)
    {
        $this->authorizeAccess($examResult);
        $examResult->delete();

        return redirect()->route('exam-results.index')->with('success', 'Result deleted.');
    }

    public function publish(ExamResult $examResult)
    {
        $this->authorizeAccess($examResult);

        $examResult->update([
            'published' => true,
            'published_by' => auth()->user()->id,
            'published_at' => now(),
        ]);

        return redirect()->route('exam-results.index')->with('success', 'Result published.');
    }


    public function generalResults(Request $request)
{
    $user = auth()->user();
    $schoolId = $user->school_id;

    $query = ExamResult::with(['student.user', 'exam.subject', 'exam.examType', 'exam.academicYear'])
        ->where('school_id', $schoolId);

    if ($request->filled('grade_id')) {
        $query->whereHas('exam', fn($q) => $q->where('grade_id', $request->grade_id));
    }

    if ($request->filled('academic_year_id')) {
        $query->whereHas('exam', fn($q) => $q->where('academic_year_id', $request->academic_year_id));
    }

    if ($request->filled('subject_id')) {
        $query->whereHas('exam', fn($q) => $q->where('subject_id', $request->subject_id));
    }

    $results = $query->orderByDesc('created_at')->paginate(25);

    $academicYears = \App\Models\AcademicYear::where('school_id', $schoolId)->latest()->get();
    $subjects = \App\Models\Subject::where('school_id', $schoolId)->get();
    $grades = \App\Models\GradeLevel::where('school_id', $schoolId)->get();

    return view('in.school.exams.results.general', compact('results', 'academicYears', 'subjects', 'grades'));
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
