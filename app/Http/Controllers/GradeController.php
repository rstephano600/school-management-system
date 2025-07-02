<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Classes;
use App\Models\Student;
use App\Models\Submission;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function index()
    {
        $schoolId = auth()->user()->school_id;

        $grades = Grade::with(['student', 'class', 'submission', 'grader'])
            ->where('school_id', $schoolId)
            ->latest('grade_date')
            ->paginate(20);

        return view('in.school.grades.index', compact('grades'));
    }

    public function create()
    {
        $schoolId = auth()->user()->school_id;

        return view('in.school.grades.create', [
            'students' => Student::where('school_id', $schoolId)->get(),
            'classes' => Classes::where('school_id', $schoolId)->get(),
            'submissions' => Submission::where('school_id', $schoolId)->get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,user_id',
            'class_id' => 'required|exists:classes,id',
            'submission_id' => 'nullable|exists:submissions,id',
            'score' => 'required|numeric|min:0',
            'max_score' => 'required|numeric|min:0|gte:score',
            'grade_value' => 'nullable|string|max:5',
            'comments' => 'nullable|string',
            'grade_date' => 'required|date',
        ]);

        Grade::create([
            'school_id' => auth()->user()->school_id,
            'submission_id' => $request->submission_id,
            'student_id' => $request->student_id,
            'class_id' => $request->class_id,
            'grade_value' => $request->grade_value,
            'score' => $request->score,
            'max_score' => $request->max_score,
            'comments' => $request->comments,
            'graded_by' => auth()->user()->id,
            'grade_date' => $request->grade_date,
        ]);

        return redirect()->route('grades.index')->with('success', 'Grade recorded successfully.');
    }

    public function show(Grade $grade)
    {
        $this->authorizeAccess($grade);
        return view('in.school.grades.show', compact('grade'));
    }

    public function edit(Grade $grade)
    {
        $this->authorizeAccess($grade);

        $schoolId = auth()->user()->school_id;

        return view('in.school.grades.edit', [
            'grade' => $grade,
            'students' => Student::where('school_id', $schoolId)->get(),
            'classes' => Classes::where('school_id', $schoolId)->get(),
            'submissions' => Submission::where('school_id', $schoolId)->get(),
        ]);
    }

    public function update(Request $request, Grade $grade)
    {
        $this->authorizeAccess($grade);

        $request->validate([
            'student_id' => 'required|exists:students,user_id',
            'class_id' => 'required|exists:classes,id',
            'submission_id' => 'nullable|exists:submissions,id',
            'score' => 'required|numeric|min:0',
            'max_score' => 'required|numeric|min:0|gte:score',
            'grade_value' => 'nullable|string|max:5',
            'comments' => 'nullable|string',
            'grade_date' => 'required|date',
        ]);

        $grade->update([
            'submission_id' => $request->submission_id,
            'student_id' => $request->student_id,
            'class_id' => $request->class_id,
            'grade_value' => $request->grade_value,
            'score' => $request->score,
            'max_score' => $request->max_score,
            'comments' => $request->comments,
            'grade_date' => $request->grade_date,
        ]);

        return redirect()->route('grades.index')->with('success', 'Grade updated successfully.');
    }

    public function destroy(Grade $grade)
    {
        $this->authorizeAccess($grade);
        $grade->delete();

        return redirect()->route('grades.index')->with('success', 'Grade deleted.');
    }

    private function authorizeAccess(Grade $grade)
    {
        if ($grade->school_id !== auth()->user()->school_id && auth()->user()->role !== 'superadmin') {
            abort(403);
        }
    }
}
