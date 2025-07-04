<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Grade;
use App\Models\School;
use Illuminate\Support\Facades\Auth;

class GradeController extends Controller
{
    public function index()
    {
        $grades = Grade::where('school_id', auth()->user()->school_id)
            ->orderBy('min_score', 'desc')
            ->paginate(20);

        return view('in.school.grades.index', compact('grades'));
    }

    public function create()
    {
        return view('in.school.grades.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'min_score' => 'required|integer|min:0|max:100',
            'max_score' => 'required|integer|min:0|max:100|gte:min_score',
            'grade_letter' => 'required|string|max:2',
            'grade_point' => 'required|numeric|min:0|max:5',
            'remarks' => 'nullable|string|max:100',
            'level' => 'nullable|string|max:50',
        ]);

        $validated['school_id'] = auth()->user()->school_id;
        $validated['created_by'] = auth()->id();

        Grade::create($validated);

        return redirect()->route('grades.index')->with('success', 'Grade added successfully.');
    }

    public function show(Grade $grade)
    {
        $this->authorizeGrade($grade);
        return view('in.school.grades.show', compact('grade'));
    }

    public function edit(Grade $grade)
    {
        $this->authorizeGrade($grade);
        return view('in.school.grades.edit', compact('grade'));
    }

    public function update(Request $request, Grade $grade)
    {
        $this->authorizeGrade($grade);

        $validated = $request->validate([
            'min_score' => 'required|integer|min:0|max:100',
            'max_score' => 'required|integer|min:0|max:100|gte:min_score',
            'grade_letter' => 'required|string|max:2',
            'grade_point' => 'required|numeric|min:0|max:5',
            'remarks' => 'nullable|string|max:100',
            'level' => 'nullable|string|max:50',
        ]);

        $validated['updated_by'] = auth()->id();

        $grade->update($validated);

        return redirect()->route('grades.index')->with('success', 'Grade updated successfully.');
    }

    public function destroy(Grade $grade)
    {
        $this->authorizeGrade($grade);
        $grade->delete();

        return redirect()->route('grades.index')->with('success', 'Grade deleted.');
    }

    private function authorizeGrade(Grade $grade)
    {
        if ($grade->school_id !== auth()->user()->school_id) {
            abort(403, 'Unauthorized access.');
        }
    }
}
