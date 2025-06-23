<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AcademicYearController extends Controller
{

public function index()
{
    $academicYears = AcademicYear::where('school_id', auth()->user()->school_id)->latest()->get();
    return view('in.school.academic_years.index', compact('academicYears'));
}

public function create()
{
    return view('in.school.academic_years.create');
}

public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:50',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'description' => 'nullable|string',
    ]);

    AcademicYear::create([
        'school_id' => auth()->user()->school_id,
        'name' => $request->name,
        'start_date' => $request->start_date,
        'end_date' => $request->end_date,
        'description' => $request->description,
        'is_current' => $request->has('is_current'),
    ]);

    return redirect()->route('academic-years.index')->with('success', 'Academic Year created.');
}

public function edit(AcademicYear $academicYear)
{
    return view('in.school.academic_years.edit', compact('academicYear'));
}

public function update(Request $request, AcademicYear $academicYear)
{
    $request->validate([
        'name' => 'required|string|max:50',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'description' => 'nullable|string',
    ]);

    $academicYear->update([
        'name' => $request->name,
        'start_date' => $request->start_date,
        'end_date' => $request->end_date,
        'description' => $request->description,
        'is_current' => $request->has('is_current'),
    ]);

    return redirect()->route('academic-years.index')->with('success', 'Academic Year updated.');
}

public function destroy(AcademicYear $academicYear)
{
    $academicYear->delete();
    return redirect()->route('academic-years.index')->with('success', 'Academic Year deleted.');
}

}
