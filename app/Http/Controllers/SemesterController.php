<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use App\Models\AcademicYear;
use Illuminate\Http\Request;

class SemesterController extends Controller
{
public function index(Request $request)
{
    $schoolId = auth()->user()->school_id;

    // Search and sort parameters
    $search = $request->input('search');
    $sortBy = $request->input('sort_by', 'start_date'); // default sort
    $order = $request->input('order', 'asc'); // default asc

    $semesters = Semester::with('academicYear')
        ->where('school_id', $schoolId)
        ->when($search, function ($query, $search) {
            $query->where('name', 'like', "%$search%")
                  ->orWhereHas('academicYear', function ($q) use ($search) {
                      $q->where('name', 'like', "%$search%");
                  });
        })
        ->orderBy($sortBy, $order)
        ->paginate(10)
        ->appends([
            'search' => $search,
            'sort_by' => $sortBy,
            'order' => $order,
        ]);

    return view('in.school.academic.semesters.index', compact('semesters', 'search', 'sortBy', 'order'));
}


public function create()
{
    $schoolId = auth()->user()->school_id;
    $academicYears = \App\Models\AcademicYear::where('school_id', $schoolId)->get();

    return view('in.school.academic.semesters.create', compact('academicYears'));
}

public function store(Request $request)
{
    $request->validate([
        'academic_year_id' => 'required|exists:academic_years,id',
        'name' => 'required|string',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
    ]);

    Semester::create([
        'school_id' => auth()->user()->school_id,
        'academic_year_id' => $request->academic_year_id,
        'name' => $request->name,
        'start_date' => $request->start_date,
        'end_date' => $request->end_date,
        'is_current' => false,
    ]);

    return redirect()->route('semesters.index')->with('success', 'Semester created successfully.');
}


public function edit(Semester $semester)
{
    $userSchoolId = auth()->user()->school_id;

    if ($semester->school_id !== $userSchoolId) {
        abort(403, 'Unauthorized action.');
    }

    $academicYears = \App\Models\AcademicYear::where('school_id', $userSchoolId)->get();

    return view('in.school.academic.semesters.edit', compact('semester', 'academicYears'));
}


   public function update(Request $request, Semester $semester)
{
    $userSchoolId = auth()->user()->school_id;

    if ($semester->school_id !== $userSchoolId) {
        abort(403, 'Unauthorized action.');
    }

    $request->validate([
        'academic_year_id' => 'required|exists:academic_years,id',
        'name' => 'required|string',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
    ]);

    $semester->update([
        'academic_year_id' => $request->academic_year_id,
        'name' => $request->name,
        'start_date' => $request->start_date,
        'end_date' => $request->end_date,
    ]);

    return redirect()->route('semesters.index')->with('success', 'Semester updated successfully.');
}

}
