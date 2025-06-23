<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentFeeController extends Controller
{
use App\Models\FeeStructure;
use App\Models\AcademicYear;
use App\Models\FeePayment;

public function index(Request $request)
{
    $student = auth()->user();
    $schoolId = $student->school_id;

    $academicYears = AcademicYear::all();
    $yearId = $request->input('academic_year_id');

    $fees = FeeStructure::where('school_id', $schoolId)
        ->when($yearId, fn($q) => $q->where('academic_year_id', $yearId))
        ->where('is_active', true)
        ->orderBy('due_date')
        ->get();


foreach ($fees as $fee) {
    $fee->payments = FeePayment::where('student_id', $student->id)
        ->where('fee_structure_id', $fee->id)
        ->get();

    $fee->total_paid = $fee->payments->sum('amount_paid');
    $fee->balance = $fee->amount - $fee->total_paid;
}

    return view('in.student.fees.index', compact('fees', 'academicYears', 'yearId'));
}

}
