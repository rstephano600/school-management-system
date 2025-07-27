<?php
namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamType;
use App\Models\AcademicYear;
use App\Models\GradeLevel;
use App\Models\Subject;
use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
public function index(Request $request)
{
    $user = auth()->user();
    $schoolId = $user->school_id;

    $query = Exam::with(['examType', 'academicYear', 'semester', 'grade', 'subject', 'creator'])
        ->where('school_id', $schoolId);

    // Role-based access
    if (!in_array($user->role, ['superadmin', 'school_admin', 'academic_master', 'teacher'])) {
        $query->where('created_by', $user->id);
    }

    // Filtering
    if ($request->filled('academic_year_id')) {
        $query->where('academic_year_id', $request->academic_year_id);
    }
    if ($request->filled('semester_id')) {
        $query->where('semester_id', $request->semester_id);
    }

    if ($request->filled('exam_type_id')) {
        $query->where('exam_type_id', $request->exam_type_id);
    }

    if ($request->filled('grade_id')) {
        $query->where('grade_id', $request->grade_id);
    }

    if ($request->filled('subject_id')) {
        $query->where('subject_id', $request->subject_id);
    }

    $exams = $query->latest()->paginate(20);

    // For filter dropdowns
    $academicYears = AcademicYear::where('school_id', $schoolId)->orderByDesc('start_date')->get();
    $grades = GradeLevel::where('school_id', $schoolId)->get();
    $subjects = Subject::where('school_id', $schoolId)->get();
    $examTypes = ExamType::where('school_id', $schoolId)->get();
    $semesters = Semester::where('school_id', $schoolId)->get();

    return view('in.school.exams.index', compact('exams', 'examTypes', 'academicYears', 'semesters', 'grades', 'subjects'));
}


    public function create()
    {
        $schoolId = auth()->user()->school_id;

        return view('in.school.exams.create', [
            'examTypes' => ExamType::where('school_id', $schoolId)->get(),
            'academicYears' => AcademicYear::where('school_id', $schoolId)->get(),
            'grades' => GradeLevel::where('school_id', $schoolId)->get(),
            'subjects' => Subject::where('school_id', $schoolId)->get(),
            'semesters' => Semester::where('school_id', $schoolId)->get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'exam_type_id' => 'required|exists:exam_types,id',
            'title' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'academic_year_id' => 'required|exists:academic_years,id',
            'semester_id' => 'required|exists:semesters,id',
            'grade_id' => 'nullable|exists:grade_levels,id',
            'subject_id' => 'nullable|exists:subject,id',
            'total_marks' => 'required|numeric|min:1',
            'passing_marks' => 'required|numeric|min:0|lte:total_marks',
            'status' => 'required|in:upcoming,ongoing,completed',
        ]);

        Exam::create([
            'school_id' => auth()->user()->school_id,
            'exam_type_id' => $request->exam_type_id,
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'academic_year_id' => $request->academic_year_id,
            'semester_id' => $request->semester_id,
            'grade_id' => $request->grade_id,
            'subject_id' => $request->subject_id,
            'total_marks' => $request->total_marks,
            'passing_marks' => $request->passing_marks,
            'status' => $request->status,
            'created_by' => 16,
        ]);

        return redirect()->route('exams.index')->with('success', 'Exam created successfully.');
    }

    public function show(Exam $exam)
    {
        $this->authorizeAccess($exam);
        return view('in.school.exams.show', compact('exam'));
    }

    public function edit(Exam $exam)
    {
        $this->authorizeAccess($exam);

        $schoolId = auth()->user()->school_id;

        return view('in.school.exams.edit', [
            'exam' => $exam,
            'examTypes' => ExamType::where('school_id', $schoolId)->get(),
            'academicYears' => AcademicYear::where('school_id', $schoolId)->get(),
            'grades' => GradeLevel::where('school_id', $schoolId)->get(),
            'subjects' => Subject::where('school_id', $schoolId)->get(),
            'semester' => Semester::where('school_id', $schoolId)->get(),
        ]);
    }

    public function update(Request $request, Exam $exam)
    {
        $this->authorizeAccess($exam);

        $request->validate([
            'exam_type_id' => 'required|exists:exam_types,id',
            'title' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'academic_year_id' => 'required|exists:academic_years,id',
            'semester_id' => 'required|exists:semesters,id',
            'grade_id' => 'nullable|exists:grade_levels,id',
            'subject_id' => 'nullable|exists:subject,id',
            'total_marks' => 'required|numeric|min:1',
            'passing_marks' => 'required|numeric|min:0|lte:total_marks',
            'status' => 'required|in:upcoming,ongoing,completed',
        ]);

        $exam->update($request->only([
            'exam_type_id',
            'title',
            'description',
            'start_date',
            'end_date',
            'academic_year_id',
            'semester_id',
            'grade_id',
            'subject_id',
            'total_marks',
            'passing_marks',
            'status',
        ]));

        return redirect()->route('exams.index')->with('success', 'Exam updated successfully.');
    }

    public function destroy(Exam $exam)
    {
        $this->authorizeAccess($exam);
        $exam->delete();

        return redirect()->route('exams.index')->with('success', 'Exam deleted.');
    }

    private function authorizeAccess(Exam $exam)
    {
        if ($exam->school_id !== auth()->user()->school_id && auth()->user()->role !== 'superadmin') {
            abort(403);
        }
    }
}
