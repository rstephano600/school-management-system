<?php


namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Assessment;
use App\Models\AcademicYear;
use App\Models\GradeLevel;
use App\Models\Subject;
use App\Models\Semester;
use Illuminate\Support\Facades\Auth;

class AssessmentController extends Controller
{
    public function index(Request $request)
    {
        $schoolId = Auth::user()->school_id;

        $query = Assessment::where('school_id', $schoolId)
            ->with(['gradeLevel', 'subject', 'academicYear', 'semester']);

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('academic_year_id')) {
            $query->where('academic_year_id', $request->academic_year_id);
        }

        $assessments = $query->orderBy('due_date', 'desc')->paginate(15);

        return view('in.school.assessments.index', compact('assessments'));
    }

    public function create()
    {
        $schoolId = Auth::user()->school_id;

        return view('in.school.assessments.create', [
            'gradeLevels'    => GradeLevel::where('school_id', $schoolId)->get(),
            'subjects'       => Subject::where('school_id', $schoolId)->get(),
            'academicYears'  => AcademicYear::where('school_id', $schoolId)->get(),
            'semesters'      => Semester::where('school_id', $schoolId)->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'             => 'required|string|max:255',
            'type'              => 'required|in:exam,test,assignment,lab',
            'grade_level_id'    => 'required|exists:grade_levels,id',
            'subject_id'        => 'required|exists:subject,id',
            'academic_year_id'  => 'required|exists:academic_years,id',
            'semester_id'       => 'nullable|exists:semesters,id',
            'due_date'          => 'nullable|date',
            'description'       => 'nullable|string',
        ]);

        $validated['school_id'] = Auth::user()->school_id;

        Assessment::create($validated);

        return redirect()->route('assessments.index')->with('success', 'Assessment created successfully.');
    }

    public function show(Assessment $assessment)
    {
        $this->authorizeSchoolAccess($assessment->school_id);

        return view('in.school.assessments.show', compact('assessment'));
    }

    public function edit(Assessment $assessment)
    {
        $this->authorizeSchoolAccess($assessment->school_id);

        $schoolId = Auth::user()->school_id;

        return view('in.school.assessments.edit', [
            'assessment'     => $assessment,
            'gradeLevels'    => GradeLevel::where('school_id', $schoolId)->get(),
            'subjects'       => Subject::where('school_id', $schoolId)->get(),
            'academicYears'  => AcademicYear::where('school_id', $schoolId)->get(),
            'semesters'      => Semester::where('school_id', $schoolId)->get(),
        ]);
    }

    public function update(Request $request, Assessment $assessment)
    {
        $this->authorizeSchoolAccess($assessment->school_id);

        $validated = $request->validate([
            'title'             => 'required|string|max:255',
            'type'              => 'required|in:exam,test,assignment,lab',
            'grade_level_id'    => 'required|exists:grade_levels,id',
            'subject_id'        => 'required|exists:subject,id',
            'academic_year_id'  => 'required|exists:academic_years,id',
            'semester_id'       => 'nullable|exists:semesters,id',
            'due_date'          => 'nullable|date',
            'description'       => 'nullable|string',
        ]);

        $assessment->update($validated);

        return redirect()->route('assessments.index')->with('success', 'Assessment updated successfully.');
    }

    public function destroy(Assessment $assessment)
    {
        $this->authorizeSchoolAccess($assessment->school_id);

        $assessment->delete();

        return redirect()->route('assessments.index')->with('success', 'Assessment deleted successfully.');
    }

    protected function authorizeSchoolAccess($schoolId)
    {
        if (Auth::user()->role !== 'superadmin' && Auth::user()->school_id !== $schoolId) {
            abort(403, 'Unauthorized access to this school\'s data.');
        }
    }
}
