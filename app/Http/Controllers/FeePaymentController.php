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
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class FeePaymentController extends Controller
{
    public function index(Request $request)
{
    $query = FeePayment::with(['student', 'fee.academicYear', 'fee.school', 'receivedBy']);

    // --- Confidentiality Enhancement ---
    // Assuming the authenticated user has a 'school_id' attribute or relationship.
    // Adjust `auth()->user()->school_id` to how your application
    // retrieves the authenticated user's associated school ID.
    $userSchoolId = auth()->user()->school_id ?? null; // Get the authenticated user's school ID

    // Initialize an empty array for active filters to be passed to calculatePaymentStats
    $activeFilters = $request->except(['page']); // Get all request parameters except pagination

    if ($userSchoolId) {
        // If the user is associated with a school, always filter by that school_id
        $query->whereHas('fee', function ($q) use ($userSchoolId) {
            $q->where('school_id', $userSchoolId);
        });

        // Ensure the school_id filter is consistently applied for stats as well
        $activeFilters['school_id'] = $userSchoolId;
    } else {
        // If no userSchoolId, and a school_id is provided in the request, use it
        // This allows super-admins to filter by school_id
        if ($request->filled('school_id')) {
            $query->whereHas('fee', function ($q) use ($request) {
                $q->where('school_id', $request->school_id);
            });
        }
    }
    // --- End Confidentiality Enhancement ---

    // Get filter options
    $academicYears = AcademicYear::all();
    $feeStructures = FeeStructure::with('academicYear')->where('is_active', true)->get();

    // Only show the user's school in the dropdown if they are restricted,
    // otherwise show all schools for super-admins.
    $schools = $userSchoolId ? School::where('id', $userSchoolId)->get() : School::all();


    // Apply other filters
    if ($request->filled('academic_year_id')) {
        $query->whereHas('fee', function ($q) use ($request) {
            $q->where('academic_year_id', $request->academic_year_id);
        });
    }

    if ($request->filled('fee_structure_id')) {
        $query->where('fee_structure_id', $request->fee_structure_id);
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

    // Calculate payment statistics using the adjusted filters
    // This assumes calculatePaymentStats can accept an array of filters or a Request object.
    // If it expects a Request object, you might need to create a new Request instance
    // or modify calculatePaymentStats to accept an array of filters.
    $paymentStats = $this->calculatePaymentStats(new Request($activeFilters));


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
    // Build the base query
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

    // Apply filters
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

    // Execute and group manually (groupBy required for raw SQL aggregations)
    $results = $statsQuery->groupBy(
        'fee_payments.student_id',
        'users.name',
        'fee_structures.id',
        'fee_structures.name',
        'fee_structures.amount'
    )->get();

    // Manually paginate the results
    $page = $request->get('page', 1);
    $perPage = 15;
    $offset = ($page - 1) * $perPage;

    $paginatedResults = new LengthAwarePaginator(
        $results->slice($offset, $perPage)->values(),
        $results->count(),
        $perPage,
        $page,
        ['path' => request()->url(), 'query' => $request->query()]
    );

    return $paginatedResults;
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
        // Apply confidentiality logic here as well
        $userSchoolId = auth()->user()->school_id ?? null; // Adjust as per your user model

        // Pass the request and userSchoolId to the export class
        return Excel::download(new FeePaymentsExport($request, $userSchoolId), 'fee_payments_' . now()->format('YmdHis') . '.xlsx');
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
