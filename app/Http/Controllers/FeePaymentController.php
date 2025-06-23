<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FeeStructure;
use App\Models\FeePayment;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class FeePaymentController extends Controller
{


public function create(User $student)
{
    $fees = FeeStructure::where('school_id', $student->school_id)
        ->where('is_active', true)
        ->get();

    return view('in.school.fee_payments.create', compact('student', 'fees'));
}

public function store(Request $request, User $student)
{
    $request->validate([
        'fee_structure_id' => 'required|exists:fee_structures,id',
        'amount_paid' => 'required|numeric|min:1',
        'payment_date' => 'required|date',
        'method' => 'required|string|max:100',
        'reference' => 'nullable|string|max:255',
        'note' => 'nullable|string',
    ]);

    FeePayment::create([
        'student_id' => $student->id,
        'fee_structure_id' => $request->fee_structure_id,
        'amount_paid' => $request->amount_paid,
        'payment_date' => $request->payment_date,
        'method' => $request->method,
        'reference' => $request->reference,
        'note' => $request->note,
        'received_by' => auth()->id(),
    ]);

    return redirect()->route('students.show', $student->id)->with('success', 'Payment recorded successfully.');
}





public function search(Request $request)
{
    $query = $request->input('q');

$students = User::where('role', 'student')
    ->where('users.school_id', auth()->user()->school_id) // disambiguated
    ->join('students', 'users.id', '=', 'students.user_id')
    ->when($query, function ($qBuilder) use ($query) {
        $qBuilder->where('users.name', 'like', "%{$query}%")
                 ->orWhere('students.admission_number', 'like', "%{$query}%");
    })
    ->select('users.*', 'students.admission_number')
    ->paginate(10);


    return view('in.school.fee_payments.search', compact('students', 'query'));
}


}
