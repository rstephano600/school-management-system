<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Assessment;
use App\Models\Student;
use App\Models\AssessmentResult;
use App\Models\GradeLevel;
use Illuminate\Support\Facades\Auth;

class AssessmentResultController extends Controller
{
    public function index(Request $request, $assessmentId)
    {
        $assessment = Assessment::with(['subject', 'gradeLevel'])->findOrFail($assessmentId);
        $this->authorizeSchoolAccess($assessment->school_id);

$search = $request->input('search');

$students = Student::with('user')
    ->where('school_id', $assessment->school_id)
    ->where('grade_id', $assessment->grade_level_id)
    ->when($search, function ($query, $search) {
        $query->where(function ($q) use ($search) {
            $q->where('admission_number', 'like', "%{$search}%")
              ->orWhereHas('user', function ($userQuery) use ($search) {
                  $userQuery->where('name', 'like', "%{$search}%");
              });
        });
    })
    ->orderBy('admission_number')
    ->paginate(20);


        $results = AssessmentResult::where('assessment_id', $assessmentId)->get();
        $resultsMap = $results->keyBy('student_id');

        return view('in.school.assessments.results.index', compact('assessment', 'students', 'resultsMap'));
    }

    public function store(Request $request, $assessmentId)
    {
        $assessment = Assessment::findOrFail($assessmentId);
        $this->authorizeSchoolAccess($assessment->school_id);

        $data = $request->validate([
            'marks.*.student_id' => 'nullable|exists:users,id',
            'marks.*.score' => 'nullable|numeric|min:0|max:100',
        ]);

        $skipped = 0;

        foreach ($data['marks'] as $mark) {
    // Skip if no score provided
            if (!isset($mark['score']) || $mark['score'] === null || $mark['score'] === '') {
                $skipped++;
                continue;
            }

            AssessmentResult::updateOrCreate(
                [
                    'assessment_id' => $assessmentId,
                    'student_id' => $mark['student_id'],
                ],
                [
                    'score' => $mark['score'],
                    'recorded_by' => Auth::id(),
                ]
            );
        }

        return redirect()->route('assessments.results.index', $assessmentId)
    ->with('success', 'Results saved successfully. ' . ($skipped > 0 ? "$skipped student(s) skipped (no score given)." : ''));

    }

    public function summary(Request $request, $studentId)
{
    $student = Student::with('user', 'grade')->where('user_id', $studentId)->firstOrFail();

    $results = AssessmentResult::with(['assessment.subject', 'assessment.academicYear'])
        ->where('student_id', $studentId)
        ->latest('assessment_id')
        ->get()
        ->groupBy(function ($result) {
            return $result->assessment->academicYear->name ?? 'Unknown Year';
        });

    return view('in.school.assessments.summary', compact('student', 'results'));
}


    protected function authorizeSchoolAccess($schoolId)
    {
        if (Auth::user()->role !== 'superadmin' && Auth::user()->school_id !== $schoolId) {
            abort(403, 'Unauthorized access to this school data.');
        }
    }
}