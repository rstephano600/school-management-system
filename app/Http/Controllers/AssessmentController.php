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

        $query = Assessment::with(['subject', 'teacher.user'])
                    ->where('school_id', $school_id);

        if ($request->has('type') && $request->type != '') {
            $query->where('type', $request->type);
        }

        if ($request->has('subject_id') && $request->subject_id != '') {
            $query->where('subject_id', $request->subject_id);
        }

        $assessments = $query->latest()->get();
        $subjects = Subject::where('school_id', $school_id)->get(); // Optional: Scope by school

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
        $request->validate([
            'type' => 'required|in:exam,test,assignment,exercise',
            'title' => 'required|string|max:255',
            'subject_id' => 'required|exists:subject,id',
            'class_id' => 'required|exists:classes,id',
            'issue_date' => 'required|date',
            'due_date' => 'nullable|date|after_or_equal:issue_date',
        ]);

        $school_id = Auth::user()->school_id;
         $teacher_id = Auth::user()->id;
        Assessment::create([
            'school_id' => $school_id,
            'academic_year_id' => 1, // You may fetch current active academic year
            'grade_id' => 1, // Optional or auto-fetch from class
            'class_id' => $request->class_id,
            'subject_id' => $request->subject_id,
            'teacher_id' => $teacher_id,
            'type' => $request->type,
            'title' => $request->title,
            'description' => $request->description,
            'issue_date' => $request->issue_date,
            'due_date' => $request->due_date,
            'is_published' => false,
        ]);

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
