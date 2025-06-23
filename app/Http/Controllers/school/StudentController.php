<?php

namespace App\Http\Controllers\school;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\User;
use App\Models\School;
use App\Models\GradeLevel;
use App\Models\Section;
use App\Models\Parents;
use App\Models\AcademicYear;
use App\Models\FeeStructure;
use App\Models\FeePayment;
use App\Models\AssignedFee;
use Carbon\Carbon;


class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index(Request $request) 
{
    $schoolId = auth()->user()->school_id;

    // Start query using students table and disambiguate school_id
    $query = Student::query()
        ->with(['user', 'grade', 'section'])
        ->where('students.school_id', $schoolId);

    // Apply search filter
    if ($request->filled('search')) {
        $search = $request->input('search');
        $query->where(function($q) use ($search) {
            $q->whereHas('user', function($subQ) use ($search) {
                $subQ->where('name', 'like', "%{$search}%");
            })
            ->orWhere('students.admission_number', 'like', "%{$search}%");
        });
    }

    // Sorting logic
    $sort = $request->input('sort', 'name');
    $direction = $request->input('direction', 'asc');

    if ($sort === 'name') {
        // Join with users table for name sorting
        $query->join('users', 'students.user_id', '=', 'users.id')
              ->orderBy('users.name', $direction)
              ->select('students.*'); // Prevent selecting user.* accidentally
    } elseif ($sort === 'admission_date') {
        $query->orderBy('students.admission_date', $direction);
    }

    // Pagination
    $students = $query->paginate(10)->appends($request->query());

    return view('in.school.students.index', compact('students', 'sort', 'direction'));
}

    /**
     * Show the form for creating a new resource.
     */
public function create()
{
    // fetch grades and sections for dropdowns
    $grades = GradeLevel::all();
    $sections = Section::all();
    return view('in.school.students.create', compact('grades', 'sections'));
}

  public function store(Request $request)
{
    try {
        // Validate input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'admission_date' => 'required|date',
            'grade_id' => 'required|exists:grade_levels,id',
            'date_of_birth' => 'required|date',
            'gender' => ['required', 'in:male,female'],
            'blood_group' => ['nullable', 'in:A+,A-,B+,B-,AB+,AB-,O+,O-,O'],
            'religion' => ['nullable', 'string', 'max:50'],
            'nationality' => ['required', 'string', 'max:50'],
            'is_transport' => ['nullable', 'boolean'],
            'is_hostel' => ['nullable', 'boolean'],
            'status' => ['required', 'in:active,graduated,transferred,dropped'],
            'previous_school_info' => ['nullable', 'array'],
        ]);

        // Create user
        $user = User::create([
            'school_id' => auth()->user()->school_id,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt('12345678'), // Hash password!
            'role' => 'student',
        ]);

        // Fetch the school code from the authenticated user’s school
        $school = auth()->user()->school;
        if (!$school) {
            return back()->withErrors(['school' => 'Invalid school selected']);
        }

        $schoolCode = $school->code;

        // Generate admission number
        $randomNumber = mt_rand(100000, 999999);
        $admissionNumber = $schoolCode . '-' . $randomNumber;

        // Create student
        Student::create([
            'user_id' => $user->id,
            'admitted_by' => auth()->id(),
            'school_id' => auth()->user()->school_id,
            'admission_number' => $admissionNumber,
            'admission_date' => $validated['admission_date'],
            'grade_id' => $validated['grade_id'],
            'date_of_birth' => $validated['date_of_birth'],
            'gender' => $validated['gender'],
            'blood_group' => $validated['blood_group'] ?? null,
            'religion' => $validated['religion'] ?? null,
            'nationality' => $validated['nationality'],
            'is_transport' => $request->has('is_transport'),
            'is_hostel' => $request->has('is_hostel'),
            'status' => $validated['status'],
            'previous_school_info' => json_encode($validated['previous_school_info'] ?? []),
        ]);

        return redirect()->route('students.index')->with('success', 'Student registered successfully!');
    } catch (\Exception $e) {
        // Handle unexpected errors
        return back()->withErrors(['error' => 'Something went wrong: ' . $e->getMessage()])->withInput();
    }
}


    /**
     * Display the specified resource.
     */


public function show(Request $request, Student $student)
{
    $student->load(['user', 'grade', 'section', 'parents.user']);

    // determine the fee eligibility range using admission_date + status
    $startDate = $student->admission_date;
    $isActive = $student->status === 'active';

    $endDate = $isActive
        ? now()
        : AcademicYear::where('school_id', $student->school_id)
            ->where('start_date', '<=', now())
            ->orderByDesc('end_date')
            ->value('end_date') ?? now();

    // fetch all academic years between start and end
    $activeYears = AcademicYear::where('school_id', $student->school_id)
        ->where('start_date', '>=', $startDate)
        ->where('start_date', '<=', $endDate)
        ->get();

    $feesByYear = [];

    foreach ($activeYears as $year) {
        $fees = FeeStructure::where('school_id', $student->school_id)
            ->where('academic_year_id', $year->id)
            ->where('is_active', true)
            ->with('academicYear')
            ->get();

        // Fetch related fee payments
        $payments = FeePayment::with('receivedBy')
            ->where('student_id', $student->user_id)
            ->whereIn('fee_structure_id', $fees->pluck('id'))
            ->get();

        foreach ($fees as $fee) {
            $fee->paid = $payments->where('fee_structure_id', $fee->id)->sum('amount_paid');
            $fee->balance = $fee->amount - $fee->paid;
            $fee->payment_history = $payments->where('fee_structure_id', $fee->id);
        }

        $feesByYear[$year->name] = $fees;
    }

    return view('in.school.students.show', compact('student', 'feesByYear', 'activeYears'));
}


    /**
     * Show the form for editing the specified resource.
     */
public function edit(Student $student)
{
        $grades = GradeLevel::all();
    $sections = Section::all();
    return view('in.school.students.edit', compact('sections','grades','student'));
}


    /**
     * Update the specified resource in storage.
     */
public function update(Request $request, Student $student)
{

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:students,email,' . $student->id,
        'admission_date' => 'required|date',
        'grade_id' => 'required|exists:grade_levels,id',
        'section_id' => 'required|exists:sections,id',
        'date_of_birth' => 'required|date',
        'gender' => ['required', 'in:male,female,other'],
        'blood_group' => ['nullable', 'in:A+,A-,B+,B-,AB+,AB-,O+,O-'],
        'religion' => ['nullable', 'string', 'max:50'],
        'nationality' => ['required', 'string', 'max:50'],
        'is_transport' => ['nullable', 'boolean'],
        'is_hostel' => ['nullable', 'boolean'],
        'status' => ['required', 'in:active,graduated,transferred,dropped'],
        'previous_school_info' => ['nullable', 'array'],

        // add other fields
    ]);

    $student->update([
        'name' => $request->name,
        'email' => $request->email,
        // add other fields
    ]);

    return redirect()->route('students.index')->with('success', 'Student updated successfully!');
}


    /**
     * Remove the specified resource from storage.
     */
public function destroy(Student $student)
{
    $this->authorizeStudent($student);
    $student->delete();

    return redirect()->route('students.index')->with('success', 'Student deleted successfully!');
}

}
