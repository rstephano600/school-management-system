<?php

namespace App\Http\Controllers\school;
use App\Http\Controllers\Controller;
use App\Models\GradeLevel;
use App\Models\School;
use Illuminate\Http\Request;

class GradeLevelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index()
{
    $schoolId = auth()->user()->school_id;

    $gradeLevels = GradeLevel::with('school')
        ->where('school_id', $schoolId)
        ->orderedByLevel()
        ->paginate(20);

    return view('in.school.grade_levels.index', compact('gradeLevels'));
}


    /**
     * Show the form for creating a new resource.
     */
public function create()
{
    return view('in.school.grade_levels.create');
}


    /**
     * Store a newly created resource in storage.
     */
public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:50',
        'code' => 'required|string|max:10|unique:grade_levels,code',
        'level' => 'required|integer',
        'description' => 'nullable|string',
    ]);

    $validated['school_id'] = auth()->user()->school_id;

    GradeLevel::create($validated);

    return redirect()->route('grade-levels.index')
        ->with('success', 'Grade level created successfully.');
}


    /**
     * Display the specified resource.
     */
public function show(GradeLevel $gradeLevel)
{
    if ($gradeLevel->school_id !== auth()->user()->school_id) {
        abort(403, 'Unauthorized access.');
    }

    $gradeLevel->load(['school', 'students']);
    return view('in.school.grade_levels.show', compact('gradeLevel'));
}

    /**
     * Show the form for editing the specified resource.
     */
public function edit(GradeLevel $gradeLevel)
{
    if ($gradeLevel->school_id !== auth()->user()->school_id) {
        abort(403, 'Unauthorized access.');
    }
    $gradeLevel->load(['school', 'students']);
    return view('in.school.grade_levels.edit', compact('gradeLevel'));
}


    /**
     * Update the specified resource in storage.
     */
public function update(Request $request, GradeLevel $gradeLevel)
{
    if ($gradeLevel->school_id !== auth()->user()->school_id) {
        abort(403, 'Unauthorized action.');
    }

    $validated = $request->validate([
        'name' => 'required|string|max:50',
        'code' => 'required|string|max:10|unique:grade_levels,code,'.$gradeLevel->id,
        'level' => 'required|integer',
        'description' => 'nullable|string',
    ]);

    $gradeLevel->update($validated);

    return redirect()->route('grade-levels.show', $gradeLevel->id)
        ->with('success', 'Grade level updated successfully.');
}


    /**
     * Remove the specified resource from storage.
     */
public function destroy(GradeLevel $gradeLevel)
{
    if ($gradeLevel->school_id !== auth()->user()->school_id) {
        abort(403, 'Unauthorized action.');
    }

    $gradeLevel->delete();

    return redirect()->route('grade-levels.index')
        ->with('success', 'Grade level deleted successfully.');
}


    /**
     * Get grade levels by school (for API or AJAX requests)
     */
public function bySchool(School $school)
{
    if ($school->id !== auth()->user()->school_id) {
        abort(403, 'Unauthorized access.');
    }

    $gradeLevels = GradeLevel::where('school_id', $school->id)
        ->orderedByLevel()
        ->get();

    return response()->json($gradeLevels);
}

}