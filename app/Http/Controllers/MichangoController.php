<?php

namespace App\Http\Controllers;

use App\Models\MichangoCategory;
use App\Models\StudentMichango;
use App\Models\Student;
use App\Models\GradeLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MichangoController extends Controller
{
    public function index(Request $request)
    {
        $school = auth()->user()->school;
        
        $query = MichangoCategory::where('school_id', $school->id)
            ->with(['createdBy', 'studentMichango']);

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true)
                      ->where('end_date', '>', now());
            } elseif ($request->status === 'completed') {
                $query->whereRaw('collected_amount >= target_amount');
            } elseif ($request->status === 'expired') {
                $query->where('end_date', '<', now());
            }
        }

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $michangoCategories = $query->latest()->paginate(15);
        
        // Calculate statistics
        $stats = [
            'total_categories' => MichangoCategory::where('school_id', $school->id)->count(),
            'active_categories' => MichangoCategory::where('school_id', $school->id)
                ->where('is_active', true)
                ->where('end_date', '>', now())
                ->count(),
            'total_target' => MichangoCategory::where('school_id', $school->id)->sum('target_amount'),
            'total_collected' => MichangoCategory::where('school_id', $school->id)->sum('collected_amount')
        ];

        return view('in.school.michango.index', compact('michangoCategories', 'stats'));
    }

    public function create()
    {
        $school = auth()->user()->school;
        $grades = GradeLevel::where('school_id', $school->id)
            ->orderBy('level')->get();

        return view('in.school.michango.create', compact('grades'));
    }

    public function store(Request $request)
    {
        $school = auth()->user()->school;

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:michango_categories,code',
            'description' => 'required|string',
            'target_amount' => 'required|numeric|min:1',
            'suggested_amount' => 'nullable|numeric|min:0',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'nullable|date|after:start_date',
            'contribution_type' => 'required|in:per_student,per_parent,voluntary',
            'applicable_grades' => 'nullable|array',
            'applicable_grades.*' => 'exists:grade_levels,id'
        ]);

        $validated['school_id'] = $school->id;
        $validated['created_by'] = auth()->id();
        $validated['is_active'] = true;
        $validated['collected_amount'] = 0;

        MichangoCategory::create($validated);

        return redirect()->route('michango.index')
            ->with('success', 'Michango category created successfully.');
    }

    public function show(MichangoCategory $michangoCategory)
    {
        $this->authorize('view', $michangoCategory);

        $michangoCategory->load([
            'createdBy',
            'studentMichango.student.user',
            'studentMichango.student.grade',
            'studentMichango.payments.receivedBy'
        ]);

        $contributionStats = [
            'total_students' => $michangoCategory->studentMichango->count(),
            'students_pledged' => $michangoCategory->studentMichango->where('status', '!=', 'not_pledged')->count(),
            'students_completed' => $michangoCategory->studentMichango->where('status', 'completed')->count(),
            'total_pledged' => $michangoCategory->studentMichango->sum('pledged_amount'),
            'total_paid' => $michangoCategory->studentMichango->sum('paid_amount'),
            'completion_rate' => $michangoCategory->target_amount > 0 ? 
                round(($michangoCategory->collected_amount / $michangoCategory->target_amount) * 100, 2) : 0
        ];

        return view('in.school.michango.show', compact('michangoCategory', 'contributionStats'));
    }

    public function getActiveMichango()
    {
        $school = auth()->user()->school;
        
        $michango = MichangoCategory::where('school_id', $school->id)
            ->where('is_active', true)
            ->where('end_date', '>', now())
            ->select('id', 'name', 'suggested_amount', 'target_amount', 'collected_amount')
            ->get();

        return response()->json($michango);
    }
}