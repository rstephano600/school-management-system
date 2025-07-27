<?php

namespace App\Http\Controllers;

use App\Models\StudentRequirement;
use App\Models\GradeLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentRequirementController extends Controller
{
    /**
     * Display a listing of the requirements with search and pagination.
     */
    public function index(Request $request)
    {
        $schoolId = Auth::user()->school_id;

        $query = StudentRequirement::with('gradeLevel')
            ->where('school_id', $schoolId);

        // Optional search filter
        if ($search = $request->input('search')) {
            $query->where('name', 'LIKE', '%' . $search . '%');
        }

        // Optional grade filter
        if ($gradeId = $request->input('grade_level_id')) {
            $query->where('grade_level_id', $gradeId);
        }

        $requirements = $query->orderByDesc('created_at')->paginate(10);
        $gradeLevels = GradeLevel::where('school_id', $schoolId)->get();

        return view('in.school.student_requirements.index', compact('requirements', 'gradeLevels'));
    }

    /**
     * Show the form for creating a new requirement.
     */
    public function create()
    {
        $gradeLevels = GradeLevel::where('school_id', Auth::user()->school_id)->get();
        return view('in.school.student_requirements.create', compact('gradeLevels'));
    }

    /**
     * Store a new requirement in the database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'quantity' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'allow_payment' => 'required|boolean',
            'expected_amount' => 'nullable|numeric',
            'grade_level_id' => 'nullable|exists:grade_levels,id',
        ]);

        StudentRequirement::create([
            'school_id' => Auth::user()->school_id,
            'name' => $request->name,
            'quantity' => $request->quantity,
            'description' => $request->description,
            'allow_payment' => $request->allow_payment,
            'expected_amount' => $request->expected_amount,
            'grade_level_id' => $request->grade_level_id,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('student-requirements.index')->with('success', 'Requirement created successfully.');
    }

    /**
     * Show the form for editing a specific requirement.
     */
    public function edit(StudentRequirement $studentRequirement)
    {
        $this->authorizeAccess($studentRequirement);

        $gradeLevels = GradeLevel::where('school_id', Auth::user()->school_id)->get();
        return view('in.school.student_requirements.edit', compact('studentRequirement', 'gradeLevels'));
    }

    /**
     * Update an existing requirement.
     */
    public function update(Request $request, StudentRequirement $studentRequirement)
    {
        $this->authorizeAccess($studentRequirement);

        $request->validate([
            'name' => 'required|string|max:100',
            'quantity' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'allow_payment' => 'required|boolean',
            'expected_amount' => 'nullable|numeric',
            'grade_level_id' => 'nullable|exists:grade_levels,id',
        ]);

        $studentRequirement->update([
            'name' => $request->name,
            'quantity' => $request->quantity,
            'description' => $request->description,
            'allow_payment' => $request->allow_payment,
            'expected_amount' => $request->expected_amount,
            'grade_level_id' => $request->grade_level_id,
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('student-requirements.index')->with('success', 'Requirement updated successfully.');
    }

    /**
     * Delete a requirement.
     */
    public function destroy(StudentRequirement $studentRequirement)
    {
        $this->authorizeAccess($studentRequirement);
        $studentRequirement->delete();

        return redirect()->route('student-requirements.index')->with('success', 'Requirement deleted successfully.');
    }

    /**
     * Ensure the requirement belongs to the same school as the user.
     */
    protected function authorizeAccess(StudentRequirement $requirement)
    {
        if ($requirement->school_id !== Auth::user()->school_id) {
            abort(403, 'Unauthorized access.');
        }
    }
}
