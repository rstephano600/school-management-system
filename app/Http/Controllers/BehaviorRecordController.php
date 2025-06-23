<?php

namespace App\Http\Controllers;

use App\Models\BehaviorRecord;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BehaviorRecordController extends Controller
{
public function index(Request $request)
{
    $schoolId = Auth::user()->school_id;

    $query = BehaviorRecord::where('school_id', $schoolId)
        ->with(['student.user', 'reporter']);

    if ($request->filled('search')) {
        $search = $request->search;
        $query->whereHas('student.user', function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%");
        })->orWhere('incident_type', 'like', "%{$search}%");
    }

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    $records = $query->orderBy('incident_date', 'desc')->paginate(10);

    return view('in.school.behavior_records.index', compact('records'));
}

    public function create()
    {
        $students = Student::where('school_id', Auth::user()->school_id)->get();
        return view('in.school.behavior_records.create', compact('students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,user_id',
            'incident_date' => 'required|date',
            'incident_type' => 'required|in:disruption,bullying,cheating,absenteeism,other',
            'description' => 'required|string',
            'action_taken' => 'required|string',
        ]);

        BehaviorRecord::create([
            'school_id' => Auth::user()->school_id,
            'student_id' => $request->student_id,
            'incident_date' => $request->incident_date,
            'incident_type' => $request->incident_type,
            'description' => $request->description,
            'action_taken' => $request->action_taken,
            'reported_by' => Auth::id(),
        ]);

        return redirect()->route('behavior_records.index')->with('success', 'Record added.');
    }
public function show(BehaviorRecord $behavior_record)
{
    $this->authorizeSchool($behavior_record);
    return view('in.school.behavior_records.show', compact('behavior_record'));
}

    public function edit(BehaviorRecord $behavior_record)
    {
        $this->authorizeSchool($behavior_record);
        $students = Student::where('school_id', Auth::user()->school_id)->get();
        return view('in.school.behavior_records.edit', compact('behavior_record', 'students'));
    }

    public function update(Request $request, BehaviorRecord $behavior_record)
    {
        $this->authorizeSchool($behavior_record);

        $request->validate([
            'incident_date' => 'required|date',
            'incident_type' => 'required|in:disruption,bullying,cheating,absenteeism,other',
            'description' => 'required|string',
            'action_taken' => 'required|string',
            'status' => 'required|in:open,resolved',
        ]);

        $behavior_record->update([
            'incident_date' => $request->incident_date,
            'incident_type' => $request->incident_type,
            'description' => $request->description,
            'action_taken' => $request->action_taken,
            'status' => $request->status,
            'resolved_by' => $request->status === 'resolved' ? Auth::id() : null,
            'resolved_date' => $request->status === 'resolved' ? now() : null,
        ]);

        return redirect()->route('behavior_records.index')->with('success', 'Record updated.');
    }

    public function destroy(BehaviorRecord $behavior_record)
    {
        $this->authorizeSchool($behavior_record);
        $behavior_record->delete();
        return back()->with('success', 'Record deleted.');
    }

    private function authorizeSchool($record)
    {
        if ($record->school_id !== Auth::user()->school_id) {
            abort(403, 'Unauthorized.');
        }
    }
}
