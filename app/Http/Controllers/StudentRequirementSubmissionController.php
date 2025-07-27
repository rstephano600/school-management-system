<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentRequirement;
use App\Models\StudentRequirementSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentRequirementSubmissionController extends Controller
{

public function index(Request $request)
{
    $schoolId = auth()->user()->school_id;

$query = StudentRequirementSubmission::with(['student', 'requirement'])
    ->whereHas('student', function ($q) {
        $q->where('school_id', Auth::user()->school_id);
    });


    if ($request->filled('student_search')) {
        $query->whereHas('student', function ($q) use ($request) {
            $q->where('fname', 'like', '%' . $request->student_search . '%')
              ->orWhere('lname', 'like', '%' . $request->student_search . '%')
              ->orWhere('admission_number', 'like', '%' . $request->student_search . '%');
        });
    }

    if ($request->filled('student_requirement_id')) {
        $query->where('student_requirement_id', $request->student_requirement_id);
    }

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    $submissions = $query->orderBy('created_at', 'desc')->paginate(15)->appends($request->all());

    $students = Student::where('school_id', $schoolId)->get();
    $requirements = StudentRequirement::where('school_id', $schoolId)->get();

    return view('in.school.student_requirement_submissions.index', compact('submissions', 'students', 'requirements'));
}


public function create()
{
    $schoolId = auth()->user()->school_id;
    $students = Student::where('school_id', $schoolId)->get();
    $requirements = StudentRequirement::where('school_id', $schoolId)->get();

    return view('in.school.student_requirement_submissions.create', compact('students', 'requirements'));
}


    public function store(Request $request)
{
    $request->validate([
        'student_id' => 'required|exists:students,user_id',
        'requirements' => 'required|array|min:1',
        'requirements.*.student_requirement_id' => 'required|exists:student_requirements,id',
        'requirements.*.quantity_received' => 'required|numeric|min:0',
        'requirements.*.quantity_remain' => 'required|numeric|min:0',
        'requirements.*.amount_paid' => 'nullable|numeric|min:0',
        'requirements.*.notes' => 'nullable|string|max:20',
        'requirements.*.status' => 'required|in:paid,submitted',
    ]);

    foreach ($request->requirements as $entry) {
        $submission = new StudentRequirementSubmission();
        $submission->student_id = $request->student_id;
        $submission->student_requirement_id = $entry['student_requirement_id'];
        $submission->quantity_received = $entry['quantity_received'];
        $submission->quantity_remain = $entry['quantity_remain'];
        $submission->status = $entry['status'];
        $submission->amount_paid = $entry['amount_paid'] ?? 0;
        $submission->notes = $entry['notes'] ?? null;
        $submission->created_by = Auth::id();
        $submission->save();
    }

    return redirect()->route('student-requirement-submissions.index')
        ->with('success', 'All requirements submitted successfully.');
}


public function edit($id)
{
    $schoolId = auth()->user()->school_id;

    $submission = StudentRequirementSubmission::where('id', $id)
        ->whereHas('student', fn($q) => $q->where('school_id', $schoolId))
        ->firstOrFail();

    $students = Student::where('school_id', $schoolId)->get();
    $requirements = StudentRequirement::where('school_id', $schoolId)->get();

    return view('in.school.student_requirement_submissions.edit', compact('submission', 'students', 'requirements'));
}

public function update(Request $request, $id)
{
    $schoolId = auth()->user()->school_id;

    $submission = StudentRequirementSubmission::where('id', $id)
        ->whereHas('student', fn($q) => $q->where('school_id', $schoolId))
        ->firstOrFail();

    $request->validate([
        'student_id' => 'required|exists:students,user_id',
        'student_requirement_id' => 'required|exists:student_requirements,id',
        'quantity_received' => 'required|integer|min:0',
        'quantity_remain' => 'required|integer|min:0',
        'amount_paid' => 'nullable|numeric|min:0',
        'notes' => 'nullable|string|max:20',
        'status' => 'required|in:paid,submitted',
    ]);

    $submission->student_id = $request->student_id;
    $submission->student_requirement_id = $request->student_requirement_id;
    $submission->quantity_received = $request->quantity_received;
    $submission->quantity_remain = $request->quantity_remain;
    $submission->status = $request->status;
    $submission->amount_paid = $request->amount_paid;
    $submission->notes = $request->notes;
    $submission->submitted_at = now();
    $submission->fulfilled_by = Auth::id();
    $submission->updated_by = Auth::id();

    $submission->save();

    return redirect()->route('student-requirement-submissions.index')
        ->with('success', 'Submission updated successfully.');
}

public function destroy($id)
{
    $schoolId = auth()->user()->school_id;

    $submission = StudentRequirementSubmission::where('id', $id)
        ->whereHas('student', fn($q) => $q->where('school_id', $schoolId))
        ->firstOrFail();

    $submission->delete();

    return redirect()->route('student-requirement-submissions.index')
        ->with('success', 'Submission deleted successfully.');
}

}