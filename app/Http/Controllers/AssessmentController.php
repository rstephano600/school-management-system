<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\Subject;
use App\Models\GradeLevel;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssessmentController extends Controller
{
    public function index(Request $request)
{
    $school_id = Auth::user()->school_id;
    $user = Auth::user();

    $query = Assessment::with(['subject', 'teacher.user'])
        ->where('school_id', $school_id);

    // Check if the logged-in user is a teacher
    if ($user->role === 'teacher') {

        // Filter assessments created by this teacher
        $query->where('created_by', $user->id);

        // Optional: filter by assigned grade levels
        // Assuming you have a 'teacher_grade_levels' pivot table or relation
        $teacherGradeLevelIds = $user->teacher->gradeLevels->pluck('id') ?? [];

        if ($teacherGradeLevelIds->isNotEmpty()) {
            $query->whereIn('grade_level_id', $teacherGradeLevelIds);
        } else {
            // If teacher has no assigned grade levels, return none
            $query->whereRaw('1 = 0');
        }
    }

    // Filtering by type
    if ($request->has('type') && $request->type != '') {
        $query->where('type', $request->type);
    }

    // Filtering by subject
    if ($request->has('subject_id') && $request->subject_id != '') {
        $query->where('subject_id', $request->subject_id);
    }

    $assessments = $query->latest()->get();
    $subjects = Subject::where('school_id', $school_id)->get();

    return view('in.school.assessments.index', compact('assessments', 'subjects'));
}

    public function create()
    {
        $school_id = Auth::user()->school_id;
        $subjects = Subject::where('school_id', $school_id)->get();
        $classes = GradeLevel::where('school_id', $school_id)->get();
        $teachers = Teacher::with('user')->where('school_id', $school_id)->get();

        return view('in.school.assessments.create', compact('subjects', 'classes', 'teachers'));
    }

    public function store(Request $request)
{
    $schoolId = Auth::user()->school_id;
    $userId = Auth::id(); // or Auth::user()->id

    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'type' => 'required|string',
        'grade_level_id' => 'required|exists:grade_levels,id',
        'subject_id' => 'required|exists:subjects,id',
        'academic_year_id' => 'required|exists:academic_years,id',
        'semester_id' => 'required|exists:semesters,id',
        'due_date' => 'required|date',
        'description' => 'nullable|string',
    ]);

    $validated['school_id'] = $schoolId;
    $validated['created_by'] = $userId;
    $validated['updated_by'] = $userId;

    Assessment::create($validated);

    return redirect()->route('assessments.index')->with('success', 'Assessment created successfully.');
}



    public function edit(Assessment $assessment)
    {
        $school_id = Auth::user()->school_id;
        if ($assessment->school_id !== $school_id) {
            abort(403, 'Unauthorized');
        }

        $subjects = Subject::where('school_id', $school_id)->get();
        $classes = GradeLevel::where('school_id', $school_id)->get();
        $teachers = Teacher::with('user')->where('school_id', $school_id)->get();

        return view('in.school.assessments.edit', compact('assessment', 'subjects', 'classes', 'teachers'));
    }

    public function update(Request $request, Assessment $assessment)
    {
        $school_id = Auth::user()->school_id;
        if ($assessment->school_id !== $school_id) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'type' => 'required|in:exam,test,assignment,exercise',
            'title' => 'required|string|max:255',
            'subject_id' => 'required|exists:subject,id',
            'class_id' => 'required|exists:classes,id',
            'teacher_id' => 'required|exists:teachers,user_id',
            'issue_date' => 'required|date',
            'due_date' => 'nullable|date|after_or_equal:issue_date',
        ]);

        $assessment->update([
            'type' => $request->type,
            'title' => $request->title,
            'subject_id' => $request->subject_id,
            'class_id' => $request->class_id,
            'teacher_id' => $request->teacher_id,
            'issue_date' => $request->issue_date,
            'due_date' => $request->due_date,
            'description' => $request->description,
            'updated_by' => auth()->user()->id,
        ]);

        return redirect()->route('assessments.index')->with('success', 'Assessment updated successfully.');
    }

    public function destroy(Assessment $assessment)
    {
        $school_id = Auth::user()->school_id;
        if ($assessment->school_id !== $school_id) {
            abort(403, 'Unauthorized');
        }

        $assessment->delete();

        return redirect()->route('assessments.index')->with('success', 'Assessment deleted successfully.');
    }
}
