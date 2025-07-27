<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentPayment;
use App\Models\StudentPaymentRequirement;
use App\Models\PaymentCategory;
use App\Models\GradeLevelFee;
use App\Models\AcademicYear;
use App\Models\MichangoCategory;
use App\Models\StudentMichango;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StudentPaymentController extends Controller
{
    public function index(Request $request)
    {
        $school = auth()->user()->school;
        $currentAcademicYear = AcademicYear::where('school_id', $school->id)
            ->where('is_current', true)->first();

        $query = Student::where('school_id', $school->id)
            ->with(['user', 'grade', 'section', 'paymentRequirements' => function($q) use ($currentAcademicYear) {
                $q->where('academic_year_id', $currentAcademicYear->id ?? 0)
                  ->with('paymentCategory');
            }]);

        // Filters
        if ($request->filled('grade_id')) {
            $query->where('grade_id', $request->grade_id);
        }

        if ($request->filled('payment_status')) {
            $query->whereHas('paymentRequirements', function($q) use ($request, $currentAcademicYear) {
                $q->where('academic_year_id', $currentAcademicYear->id ?? 0)
                  ->where('status', $request->payment_status);
            });
        }

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('fname', 'like', '%' . $request->search . '%')
                  ->orWhere('lname', 'like', '%' . $request->search . '%')
                  ->orWhere('admission_number', 'like', '%' . $request->search . '%');
            });
        }

        $students = $query->latest()->paginate(20);
        $grades = $school->gradeLevels()->orderBy('level')->get();

        // Payment statistics
        $stats = $this->getPaymentStatistics($school, $currentAcademicYear);

        return view('in.school.payment.student-payments.index', compact('students', 'grades', 'stats', 'currentAcademicYear'));
    }

    public function show(Student $student)
    {
        $this->authorize('view', $student);

        $school = auth()->user()->school;
        $currentAcademicYear = AcademicYear::where('school_id', $school->id)
            ->where('is_current', true)->first();

        $student->load([
            'user', 
            'grade', 
            'section',
            'paymentRequirements' => function($q) use ($currentAcademicYear) {
                $q->where('academic_year_id', $currentAcademicYear->id ?? 0)
                  ->with('paymentCategory');
            },
            'payments' => function($q) use ($currentAcademicYear) {
                $q->where('academic_year_id', $currentAcademicYear->id ?? 0)
                  ->with(['paymentCategory', 'receivedBy', 'verifiedBy'])
                  ->latest();
            }
        ]);

        // Get Michango for this student
        $michango = StudentMichango::where('student_id', $student->user_id)
            ->with(['michangoCategory', 'payments.receivedBy'])
            ->get();

        // Payment summary
        $paymentSummary = [
            'total_required' => $student->paymentRequirements->sum('required_amount'),
            'total_paid' => $student->paymentRequirements->sum('paid_amount'),
            'total_balance' => $student->paymentRequirements->sum('balance'),
            'overdue_count' => $student->paymentRequirements->where('status', 'overdue')->count()
        ];

        return view('in.school.payment.student-payments.show', compact('student', 'michango', 'paymentSummary', 'currentAcademicYear'));
    }

    public function generateRequirements(Request $request)
    {
        $validated = $request->validate([
            'academic_year_id' => 'required|exists:academic_years,id',
            'grade_ids' => 'required|array',
            'grade_ids.*' => 'exists:grade_levels,id',
            'category_ids' => 'nullable|array',
            'category_ids.*' => 'exists:payment_categories,id'
        ]);

        $school = auth()->user()->school;
        $academicYear = AcademicYear::findOrFail($validated['academic_year_id']);

        DB::transaction(function() use ($validated, $school, $academicYear) {
            // Get students in selected grades
            $students = Student::where('school_id', $school->id)
                ->whereIn('grade_id', $validated['grade_ids'])
                ->where('status', 'active')
                ->get();

            foreach ($students as $student) {
                $this->generateStudentRequirements($student, $academicYear, $validated['category_ids'] ?? null);
            }
        });

        return redirect()->back()->with('success', 'Payment requirements generated successfully for ' . $students->count() . ' students.');
    }

    public function recordPayment(Request $request, Student $student)
    {
        $this->authorize('update', $student);

        $validated = $request->validate([
            'payment_category_id' => 'required|exists:payment_categories,id',
            'amount' => 'required|numeric|min:0.01',
            'payment_date' => 'required|date|before_or_equal:today',
            'payment_method' => 'required|in:cash,bank_transfer,mobile_money,cheque,card',
            'payment_reference_number' => 'nullable|string|max:255',
            'payment_notes' => 'nullable|string'
        ]);

        $school = auth()->user()->school;
        $currentAcademicYear = AcademicYear::where('school_id', $school->id)
            ->where('is_current', true)->first();

        DB::transaction(function() use ($validated, $student, $currentAcademicYear) {
            // Record the payment
            $payment = StudentPayment::create([
                'student_id' => $student->user_id,
                'payment_category_id' => $validated['payment_category_id'],
                'academic_year_id' => $currentAcademicYear->id,
                'amount' => $validated['amount'],
                'payment_date' => $validated['payment_date'],
                'payment_method' => $validated['payment_method'],
                'payment_reference_number' => $validated['payment_reference_number'],
                'payment_notes' => $validated['payment_notes'],
                'received_by' => auth()->id(),
                'status' => 'verified' // Auto-verify for now
            ]);

            // Update payment requirement
            $requirement = StudentPaymentRequirement::where('student_id', $student->user_id)
                ->where('payment_category_id', $validated['payment_category_id'])
                ->where('academic_year_id', $currentAcademicYear->id)
                ->first();

            if ($requirement) {
                $requirement->paid_amount += $validated['amount'];
                $requirement->updateBalance();
            }
        });

        return redirect()->back()->with('success', 'Payment recorded successfully.');
    }

    public function recordMichangoPayment(Request $request, Student $student)
    {
        $this->authorize('update', $student);

        $validated = $request->validate([
            'michango_category_id' => 'required|exists:michango_categories,id',
            'amount' => 'required|numeric|min:0.01',
            'payment_date' => 'required|date|before_or_equal:today',
            'payment_method' => 'required|in:cash,bank_transfer,mobile_money,cheque,card,in_kind',
            'payment_reference_number' => 'nullable|string|max:255',
            'payment_description' => 'nullable|string'
        ]);

        DB::transaction(function() use ($validated, $student) {
            // Get or create student michango record
            $studentMichango = StudentMichango::firstOrCreate(
                [
                    'student_id' => $student->user_id,
                    'michango_category_id' => $validated['michango_category_id']
                ],
                [
                    'recorded_by' => auth()->id(),
                    'status' => 'not_pledged'
                ]
            );

            // Record the payment
            $payment = $studentMichango->payments()->create([
                'amount' => $validated['amount'],
                'payment_date' => $validated['payment_date'],
                'payment_method' => $validated['payment_method'],
                'payment_reference_number' => $validated['payment_reference_number'],
                'payment_description' => $validated['payment_description'],
                'received_by' => auth()->id(),
                'verified_by' => auth()->id(),
                'verified_at' => now()
            ]);

            // Update student michango totals
            $studentMichango->paid_amount += $validated['amount'];
            $studentMichango->updateBalance();

            // Update category totals
            $category = $studentMichango->michangoCategory;
            $category->collected_amount += $validated['amount'];
            $category->save();
        });

        return redirect()->back()->with('success', 'Michango payment recorded successfully.');
    }

    public function bulkGenerateRequirements(Request $request)
    {
        $validated = $request->validate([
            'academic_year_id' => 'required|exists:academic_years,id',
            'include_all_grades' => 'boolean',
            'grade_ids' => 'required_if:include_all_grades,false|array',
            'grade_ids.*' => 'exists:grade_levels,id'
        ]);

        $school = auth()->user()->school;
        $academicYear = AcademicYear::findOrFail($validated['academic_year_id']);

        $gradeIds = $validated['include_all_grades'] 
            ? $school->gradeLevels()->pluck('id')->toArray()
            : $validated['grade_ids'];

        DB::transaction(function() use ($gradeIds, $school, $academicYear) {
            $students = Student::where('school_id', $school->id)
                ->whereIn('grade_id', $gradeIds)
                ->where('status', 'active')
                ->get();

            foreach ($students as $student) {
                $this->generateStudentRequirements($student, $academicYear);
            }
        });

        return response()->json([
            'success' => true,
            'message' => 'Payment requirements generated for all eligible students.'
        ]);
    }

    private function generateStudentRequirements(Student $student, AcademicYear $academicYear, $categoryIds = null)
    {
        // Get applicable payment categories
        $categories = PaymentCategory::where('school_id', $student->school_id)
            ->where('is_active', true)
            ->when($categoryIds, function($q) use ($categoryIds) {
                $q->whereIn('id', $categoryIds);
            })
            ->forGrade($student->grade_id)
            ->get();

        foreach ($categories as $category) {
            // Check if requirement already exists
            $existingRequirement = StudentPaymentRequirement::where('student_id', $student->user_id)
                ->where('payment_category_id', $category->id)
                ->where('academic_year_id', $academicYear->id)
                ->first();

            if ($existingRequirement) {
                continue; // Skip if already exists
            }

            // Get amount from grade level fee or use default
            $gradeFee = GradeLevelFee::where('grade_level_id', $student->grade_id)
                ->where('payment_category_id', $category->id)
                ->where('academic_year_id', $academicYear->id)
                ->where('is_active', true)
                ->first();

            $amount = $gradeFee ? $gradeFee->amount : ($category->default_amount ?? 0);

            if ($amount > 0) {
                StudentPaymentRequirement::create([
                    'student_id' => $student->user_id,
                    'payment_category_id' => $category->id,
                    'academic_year_id' => $academicYear->id,
                    'required_amount' => $amount,
                    'balance' => $amount,
                    'due_date' => $this->calculateDueDate($category, $academicYear),
                    'is_mandatory' => $category->type === 'mandatory',
                    'created_by' => auth()->id()
                ]);
            }
        }
    }

    private function calculateDueDate(PaymentCategory $category, AcademicYear $academicYear)
    {
        $startDate = Carbon::parse($academicYear->start_date);

        switch ($category->payment_frequency) {
            case 'once':
                return $startDate->addMonths(1);
            case 'monthly':
                return $startDate->addMonth();
            case 'termly':
                return $startDate->addMonths(4);
            case 'annually':
                return $startDate->addMonths(6);
            default:
                return $startDate->addMonths(1);
        }
    }

    private function getPaymentStatistics($school, $academicYear)
    {
        if (!$academicYear) {
            return [
                'total_students' => 0,
                'students_with_pending' => 0,
                'students_fully_paid' => 0,
                'total_collected' => 0,
                'total_outstanding' => 0
            ];
        }

        $totalStudents = Student::where('school_id', $school->id)
            ->where('status', 'active')->count();

        $paymentStats = StudentPaymentRequirement::where('academic_year_id', $academicYear->id)
            ->whereHas('student', function($q) use ($school) {
                $q->where('school_id', $school->id)->where('status', 'active');
            })
            ->selectRaw('
                COUNT(DISTINCT student_id) as students_with_requirements,
                SUM(CASE WHEN status = "pending" OR status = "partial" THEN 1 ELSE 0 END) as pending_payments,
                SUM(paid_amount) as total_collected,
                SUM(balance) as total_outstanding
            ')
            ->first();

        return [
            'total_students' => $totalStudents,
            'students_with_pending' => $paymentStats->pending_payments ?? 0,
            'students_fully_paid' => ($paymentStats->students_with_requirements ?? 0) - ($paymentStats->pending_payments ?? 0),
            'total_collected' => $paymentStats->total_collected ?? 0,
            'total_outstanding' => $paymentStats->total_outstanding ?? 0
        ];
    }

    public function paymentHistory(Student $student)
    {
        $this->authorize('view', $student);

        $payments = StudentPayment::where('student_id', $student->user_id)
            ->with(['paymentCategory', 'academicYear', 'receivedBy', 'verifiedBy'])
            ->latest()
            ->paginate(20);

        return view('in.school.payment.student-payments.history', compact('student', 'payments'));
    }

    public function exportPayments(Request $request)
    {
        $school = auth()->user()->school;
        
        // Implementation for exporting payment data to Excel/PDF
        // This would use Laravel Excel or similar package
        
        return response()->json(['message' => 'Export functionality to be implemented']);
    }
}