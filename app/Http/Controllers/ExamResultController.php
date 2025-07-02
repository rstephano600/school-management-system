<?php

namespace App\Http\Controllers;

use App\Models\ExamResult;
use App\Models\Exam;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Imports\ExamResultsImport;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow; // optional, if you're using headings
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\StudentsImport;


class ExamResultController extends Controller
{
    public function index()
    {
        $schoolId = auth()->user()->school_id;

        $results = ExamResult::with(['exam', 'student'])
            ->where('school_id', $schoolId)
            ->latest()
            ->paginate(20);

        return view('in.school.exams.results.index', compact('results'));
    }

    public function create()
    {
        $schoolId = auth()->user()->school_id;

        return view('in.school.exams.results.create', [
            'exams' => Exam::where('school_id', $schoolId)->get(),
            'students' => Student::where('school_id', $schoolId)->get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'student_id' => 'required|exists:students,user_id',
            'marks_obtained' => 'required|numeric|min:0',
            'grade' => 'required|string|max:5',
            'remarks' => 'nullable|string|max:1000',
        ]);

        $exam = Exam::findOrFail($request->exam_id);

        $existing = ExamResult::where('exam_id', $request->exam_id)
            ->where('student_id', $request->student_id)
            ->first();

        if ($existing) {
            return redirect()->back()->withErrors(['duplicate' => 'Result for this student already exists for the selected exam.']);
        }

        ExamResult::create([
            'school_id' => auth()->user()->school_id,
            'exam_id' => $request->exam_id,
            'student_id' => $request->student_id,
            'marks_obtained' => $request->marks_obtained,
            'grade' => $request->grade,
            'remarks' => $request->remarks,
            'published' => false,
        ]);

        return redirect()->route('exam-results.index')->with('success', 'Result recorded successfully.');
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
