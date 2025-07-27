<?php

namespace App\Http\Controllers;

use App\Models\PaymentCategory;
use App\Models\GradeLevel;
use App\Models\GradeLevelFee;
use App\Models\AcademicYear;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PaymentCategoryController extends Controller
{
    public function index(Request $request)
    {
        $school = auth()->user()->school;
        
        $query = PaymentCategory::where('school_id', $school->id)
            ->with(['createdBy', 'updatedBy']);

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('code', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $paymentCategories = $query->latest()->paginate(15);
        $gradelevels = GradeLevel::where('school_id', $school->id)
            ->orderBy('level')->get();

        return view('in.school.payment.categories.index', compact('paymentCategories', 'gradelevels'));
    }

    public function create()
    {
        $school = auth()->user()->school;
        $gradelevels = GradeLevel::where('school_id', $school->id)
            ->orderBy('level')->get();

        return view('in.school.payment.categories.create', compact('gradelevels'));
    }

    public function store(Request $request)
    {
        $school = auth()->user()->school;

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => [
                'required',
                'string',
                'max:50',
                'alpha_dash',
                Rule::unique('payment_categories')->where('school_id', $school->id)
            ],
            'type' => 'required|in:mandatory,optional,conditional',
            'category' => 'required|in:fees,bills,michango,other',
            'description' => 'nullable|string',
            'payment_frequency' => 'required|in:once,monthly,termly,annually',
            'required_at_registration' => 'boolean',
            'required_at_grade_entry' => 'boolean',
            'default_amount' => 'nullable|numeric|min:0',
            'applicable_grades' => 'nullable|array',
            'applicable_grades.*' => 'exists:grade_levels,id',
            'is_active' => 'boolean'
        ]);

        $validated['school_id'] = $school->id;
        $validated['created_by'] = auth()->id();
        $validated['code'] = Str::upper($validated['code']);

        PaymentCategory::create($validated);

        return redirect()->route('payment.categories.index')
            ->with('success', 'Payment category created successfully.');
    }

    public function show(PaymentCategory $paymentCategory)
    {
        
        $paymentCategory->load(['createdBy', 'updatedBy', 'gradeLevelFees.gradeLevel', 'gradeLevelFees.academicYear']);
        
        return view('in.school.payment.categories.show', compact('paymentCategory'));
    }

    public function edit(PaymentCategory $paymentCategory)
    {
        $school = auth()->user()->school;
        $gradelevels = GradeLevel::where('school_id', $school->id)
            ->orderBy('level')->get();

        return view('in.school.payment.categories.edit', compact('paymentCategory', 'gradelevels'));
    }

    public function update(Request $request, PaymentCategory $paymentCategory)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => [
                'required',
                'string',
                'max:50',
                'alpha_dash',
                Rule::unique('payment_categories')
                    ->where('school_id', $paymentCategory->school_id)
                    ->ignore($paymentCategory->id)
            ],
            'type' => 'required|in:mandatory,optional,conditional',
            'category' => 'required|in:fees,bills,michango,other',
            'description' => 'nullable|string',
            'payment_frequency' => 'required|in:once,monthly,termly,annually',
            'required_at_registration' => 'boolean',
            'required_at_grade_entry' => 'boolean',
            'default_amount' => 'nullable|numeric|min:0',
            'applicable_grades' => 'nullable|array',
            'applicable_grades.*' => 'exists:grade_levels,id',
            'is_active' => 'boolean'
        ]);

        $validated['updated_by'] = auth()->id();
        $validated['code'] = Str::upper($validated['code']);

        $paymentCategory->update($validated);

        return redirect()->route('payment.categories.index')
            ->with('success', 'Payment category updated successfully.');
    }

    public function destroy(PaymentCategory $paymentCategory)
    {
        $this->authorize('delete', $paymentCategory);

        // Check if category is being used
        if ($paymentCategory->gradeLevelFees()->exists()) {
            return back()->with('error', 'Cannot delete payment category that has associated fees.');
        }

        $paymentCategory->delete();

        return redirect()->route('payment.categories.index')
            ->with('success', 'Payment category deleted successfully.');
    }

    public function setupGradeFees(PaymentCategory $paymentCategory)
    {
        $this->authorize('update', $paymentCategory);
        
        $school = auth()->user()->school;
        $gradelevels = GradeLevel::where('school_id', $school->id)
            ->orderBy('level')->get();
        $academicYears = AcademicYear::where('school_id', $school->id)
            ->orderBy('start_date', 'desc')->get();

        $existingFees = GradeLevelFee::where('payment_category_id', $paymentCategory->id)
            ->with(['gradeLevel', 'academicYear'])
            ->get()
            ->groupBy('academic_year_id');

        return view('payment.categories.setup-fees', compact(
            'paymentCategory', 
            'gradelevels', 
            'academicYears', 
            'existingFees'
        ));
    }

    public function storeGradeFees(Request $request, PaymentCategory $paymentCategory)
    {
        $this->authorize('update', $paymentCategory);

        $validated = $request->validate([
            'academic_year_id' => 'required|exists:academic_years,id',
            'fees' => 'required|array',
            'fees.*.grade_level_id' => 'required|exists:grade_levels,id',
            'fees.*.amount' => 'required|numeric|min:0',
            'fees.*.notes' => 'nullable|string'
        ]);

        $school = auth()->user()->school;

        foreach ($validated['fees'] as $feeData) {
            GradeLevelFee::updateOrCreate(
                [
                    'grade_level_id' => $feeData['grade_level_id'],
                    'payment_category_id' => $paymentCategory->id,
                    'academic_year_id' => $validated['academic_year_id']
                ],
                [
                    'school_id' => $school->id,
                    'amount' => $feeData['amount'],
                    'notes' => $feeData['notes'] ?? null,
                    'is_active' => true,
                    'created_by' => auth()->id(),
                    'updated_by' => auth()->id()
                ]
            );
        }

        return redirect()->route('payment.categories.setup-fees', $paymentCategory)
            ->with('success', 'Grade level fees updated successfully.');
    }

    public function getCommonCategories()
    {
        return response()->json([
            'fees' => [
                ['name' => 'Tuition Fees', 'code' => 'TUITION_FEES'],
                ['name' => 'Admission Fee', 'code' => 'ADMISSION_FEE'],
                ['name' => 'Registration Fee', 'code' => 'REGISTRATION_FEE'],
                ['name' => 'Examination Fee', 'code' => 'EXAM_FEE'],
                ['name' => 'Laboratory Fee', 'code' => 'LAB_FEE'],
                ['name' => 'Library Fee', 'code' => 'LIBRARY_FEE'],
                ['name' => 'Sports Fee', 'code' => 'SPORTS_FEE'],
                ['name' => 'Computer Fee', 'code' => 'COMPUTER_FEE'],
                ['name' => 'Practical Fee', 'code' => 'PRACTICAL_FEE']
            ],
            'bills' => [
                ['name' => 'Transport Fee', 'code' => 'TRANSPORT_FEE'],
                ['name' => 'Hostel Fee', 'code' => 'HOSTEL_FEE'],
                ['name' => 'Meals/Lunch Fee', 'code' => 'MEALS_FEE'],
                ['name' => 'Uniform Fee', 'code' => 'UNIFORM_FEE'],
                ['name' => 'Books Fee', 'code' => 'BOOKS_FEE'],
                ['name' => 'Stationery Fee', 'code' => 'STATIONERY_FEE'],
                ['name' => 'Medical Fee', 'code' => 'MEDICAL_FEE'],
                ['name' => 'Security Fee', 'code' => 'SECURITY_FEE']
            ],
            'michango' => [
                ['name' => 'School Development', 'code' => 'SCHOOL_DEVELOPMENT'],
                ['name' => 'Building Fund', 'code' => 'BUILDING_FUND'],
                ['name' => 'Equipment Fund', 'code' => 'EQUIPMENT_FUND'],
                ['name' => 'Sports Equipment', 'code' => 'SPORTS_EQUIPMENT'],
                ['name' => 'Library Books', 'code' => 'LIBRARY_BOOKS'],
                ['name' => 'Computer Equipment', 'code' => 'COMPUTER_EQUIPMENT'],
                ['name' => 'School Bus', 'code' => 'SCHOOL_BUS'],
                ['name' => 'Generator Fund', 'code' => 'GENERATOR_FUND'],
                ['name' => 'Water Project', 'code' => 'WATER_PROJECT']
            ],
            'other' => [
                ['name' => 'Late Payment Fine', 'code' => 'LATE_PAYMENT_FINE'],
                ['name' => 'ID Card Fee', 'code' => 'ID_CARD_FEE'],
                ['name' => 'Certificate Fee', 'code' => 'CERTIFICATE_FEE'],
                ['name' => 'Graduation Fee', 'code' => 'GRADUATION_FEE'],
                ['name' => 'Field Trip Fee', 'code' => 'FIELD_TRIP_FEE']
            ]
        ]);
    }

    public function bulkToggleStatus(Request $request)
    {
        $validated = $request->validate([
            'category_ids' => 'required|array',
            'category_ids.*' => 'exists:payment_categories,id',
            'status' => 'required|boolean'
        ]);

        $school = auth()->user()->school;

        PaymentCategory::whereIn('id', $validated['category_ids'])
            ->where('school_id', $school->id)
            ->update([
                'is_active' => $validated['status'],
                'updated_by' => auth()->id()
            ]);

        $message = $validated['status'] ? 'Categories activated successfully.' : 'Categories deactivated successfully.';
        
        return response()->json(['message' => $message]);
    }
}