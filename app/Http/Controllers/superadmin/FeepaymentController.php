<?php

namespace App\Http\Controllers;

use App\Models\FeePayment;
use App\Models\FeeStructure;
use App\Models\AcademicYear;
use App\Models\User;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\FeePaymentsExport;

class FeePaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = FeePayment::with(['student', 'fee.academicYear', 'fee.school', 'receivedBy']);

        // Get filter options
        $academicYears = AcademicYear::all();
        $feeStructures = FeeStructure::with('academicYear')->where('is_active', true)->get();
        $schools = School::all();

        // Apply filters
        if ($request->filled('academic_year_id')) {
            $query->whereHas('fee', function ($q) use ($request) {
                $q->where('academic_year_id', $request->academic_year_id);
            });
        }

        if ($request->filled('fee_structure_id')) {
            $query->where('fee_structure_id', $request->fee_structure_id);
        }

        if ($request->filled('school_id')) {
            $query->whereHas('fee', function ($q) use ($request) {
                $q->where('school_id', $request->school_id);
            });
        }

        if ($request->filled('student_search')) {
            $query->whereHas('student', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->student_search . '%')
                  ->orWhere('email', 'like', '%' . $request->student_search . '%');
            });
        }

        if ($request->filled('payment_method')) {
            $query->where('method', $request->payment_method);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('payment_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('payment_date', '<=', $request->date_to);
        }

        // Get payments with pagination
        $payments = $query->orderBy('payment_date', 'desc')->paginate(15);

        // Calculate payment statistics for each student
        $paymentStats = $this->calculatePaymentStats($request);

        return view('in.school.fee_payments.index', compact(
            'payments', 
            'academicYears', 
            'feeStructures', 
            'schools', 
            'paymentStats'
        ));
    }

    private function calculatePaymentStats(Request $request)
    {
        $statsQuery = DB::table('fee_payments')
            ->join('fee_structures', 'fee_payments.fee_structure_id', '=', 'fee_structures.id')
            ->join('users', 'fee_payments.student_id', '=', 'users.id')
            ->select(
                'fee_payments.student_id',
                'users.name as student_name',
                'fee_structures.id as fee_structure_id',
                'fee_structures.name as fee_name',
                'fee_structures.amount as total_amount',
                DB::raw('SUM(fee_payments.amount_paid) as total_paid'),
                DB::raw('(fee_structures.amount - SUM(fee_payments.amount_paid)) as remaining_amount'),
                DB::raw('CASE 
                    WHEN SUM(fee_payments.amount_paid) >= fee_structures.amount THEN "Fully Paid"
                    WHEN SUM(fee_payments.amount_paid) > 0 THEN "Partially Paid"
                    ELSE "Not Paid"
                END as payment_status')
            );

        // Apply same filters as main query
        if ($request->filled('academic_year_id')) {
            $statsQuery->where('fee_structures.academic_year_id', $request->academic_year_id);
        }

        if ($request->filled('fee_structure_id')) {
            $statsQuery->where('fee_structures.id', $request->fee_structure_id);
        }

        if ($request->filled('school_id')) {
            $statsQuery->where('fee_structures.school_id', $request->school_id);
        }

        if ($request->filled('student_search')) {
            $statsQuery->where(function ($q) use ($request) {
                $q->where('users.name', 'like', '%' . $request->student_search . '%')
                  ->orWhere('users.email', 'like', '%' . $request->student_search . '%');
            });
        }

        return $statsQuery->groupBy(
            'fee_payments.student_id', 
            'users.name', 
            'fee_structures.id', 
            'fee_structures.name', 
            'fee_structures.amount'
        )->get();
    }

    public function show($id)
    {
        $payment = FeePayment::with(['student', 'fee.academicYear', 'fee.school', 'receivedBy'])
            ->findOrFail($id);

        return view('in.school.fee_payments.show', compact('payment'));
    }

    public function getStudentPaymentSummary(Request $request)
    {
        $studentId = $request->student_id;
        $feeStructureId = $request->fee_structure_id;

        $summary = DB::table('fee_payments')
            ->join('fee_structures', 'fee_payments.fee_structure_id', '=', 'fee_structures.id')
            ->where('fee_payments.student_id', $studentId)
            ->where('fee_payments.fee_structure_id', $feeStructureId)
            ->select(
                'fee_structures.amount as total_amount',
                DB::raw('SUM(fee_payments.amount_paid) as total_paid'),
                DB::raw('(fee_structures.amount - SUM(fee_payments.amount_paid)) as remaining_amount')
            )
            ->first();

        return response()->json($summary);
    }

    public function export(Request $request)
    {
        // Implementation for exporting fee payment records
        // You can add Excel/CSV export functionality here
    }


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
