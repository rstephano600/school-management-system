<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;    
use App\Models\FeeStructure;
use App\Models\AcademicYear;

class FeeStructureController extends Controller
{


public function index()
{
    $feeStructures = FeeStructure::where('school_id', auth()->user()->school_id)->latest()->get();
    return view('in.school.fees.index', compact('feeStructures'));
}

public function create()
{
    $academicYears = AcademicYear::all();
    return view('in.school.fees.create', compact('academicYears'));
}

public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'academic_year_id' => 'required|exists:academic_years,id',
        'frequency' => 'required|in:monthly,quarterly,semester,annual,one-time',
        'amount' => 'required|numeric|min:0',
        'due_date' => 'required|date',
    ]);

    FeeStructure::create([
        'school_id' => auth()->user()->school_id,
        'name' => $request->name,
        'description' => $request->description,
        'academic_year_id' => $request->academic_year_id,
        'frequency' => $request->frequency,
        'amount' => $request->amount,
        'due_date' => $request->due_date,
        'is_active' => $request->has('is_active'),
    ]);

    return redirect()->route('fee-structures.index')->with('success', 'Fee structure created.');
}

}
