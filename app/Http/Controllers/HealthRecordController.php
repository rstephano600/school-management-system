<?php

namespace App\Http\Controllers;

use App\Models\HealthRecord;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class HealthRecordController extends Controller
{
public function index(Request $request)
{
    $schoolId = Auth::user()->school_id;

    $query = HealthRecord::with('student.user')
        ->where('school_id', $schoolId);

    if ($request->filled('search')) {
        $searchTerm = $request->search;
        $query->whereHas('student.user', function ($q) use ($searchTerm) {
            $q->where('name', 'like', "%{$searchTerm}%");
        })->orWhere('blood_group', 'like', "%{$searchTerm}%");
    }

    $records = $query->orderByDesc('record_date')->paginate(10);

    return view('in.school.health_records.index', compact('records'));
}


    public function create()
    {
        $students = Student::where('school_id', Auth::user()->school_id)->get();
        return view('in.school.health_records.create', compact('students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,user_id',
            'record_date' => 'required|date',
            'height' => 'nullable|numeric',
            'weight' => 'nullable|numeric',
            'blood_group' => 'nullable|string|max:5',
        ]);

        HealthRecord::create([
            'school_id' => Auth::user()->school_id,
            'student_id' => $request->student_id,
            'record_date' => $request->record_date,
            'height' => $request->height,
            'weight' => $request->weight,
            'blood_group' => $request->blood_group,
            'vision_left' => $request->vision_left,
            'vision_right' => $request->vision_right,
            'allergies' => $request->allergies,
            'medical_conditions' => $request->medical_conditions,
            'immunizations' => $request->immunizations,
            'last_checkup_date' => $request->last_checkup_date,
            'notes' => $request->notes,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('health_records.index')->with('success', 'Health record added.');
    }

    public function show(HealthRecord $health_record)
    {
        $this->authorizeSchool($health_record);
        return view('in.school.health_records.show', compact('health_record'));
    }

    public function edit(HealthRecord $health_record)
    {
        $this->authorizeSchool($health_record);
        $students = Student::where('school_id', Auth::user()->school_id)->get();
        return view('in.school.health_records.edit', compact('health_record', 'students'));
    }

    public function update(Request $request, HealthRecord $health_record)
    {
        $this->authorizeSchool($health_record);

        $request->validate([
            'record_date' => 'required|date',
            'height' => 'nullable|numeric',
            'weight' => 'nullable|numeric',
            'blood_group' => 'nullable|string|max:5',
        ]);

        $health_record->update($request->only([
            'record_date', 'height', 'weight', 'blood_group',
            'vision_left', 'vision_right', 'allergies',
            'medical_conditions', 'immunizations',
            'last_checkup_date', 'notes'
        ]));

        return redirect()->route('health_records.index')->with('success', 'Health record updated.');
    }

    public function destroy(HealthRecord $health_record)
    {
        $this->authorizeSchool($health_record);
        $health_record->delete();
        return back()->with('success', 'Health record deleted.');
    }

    private function authorizeSchool($record)
    {
        if ($record->school_id !== Auth::user()->school_id) {
            abort(403);
        }
    }
}
