<?php

namespace App\Http\Controllers;

use App\Models\HostelAllocation;
use App\Models\Hostel;
use App\Models\HostelRoom;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HostelAllocationController extends Controller
{
    public function index()
    {
        $schoolId = Auth::user()->school_id;

        $allocations = HostelAllocation::with(['student.user', 'hostel', 'room'])
            ->where('school_id', $schoolId)
            ->latest()
            ->paginate(10);

        return view('in.school.hostels.hostel_allocations.index', compact('allocations'));
    }

    public function create(Request $request)
    {
        $schoolId = Auth::user()->school_id;
        $hostels = Hostel::where('school_id', $schoolId)->get();
        $rooms = HostelRoom::where('school_id', $schoolId)->get();
        $students = Student::where('school_id', $schoolId)->get();
        $selectedStudent = $request->student; // if passed

        return view('in.school.hostels.hostel_allocations.create', compact('hostels', 'rooms', 'students', 'selectedStudent'));
    }

public function store(Request $request)
{
    $request->validate([
        'student_id' => 'required|exists:students,user_id',
        'hostel_id' => 'required|exists:hostels,id',
        'room_id' => 'required|exists:hostel_rooms,id',
        'bed_number' => 'required|string|max:20',
        'allocation_date' => 'required|date',
    ]);

    // Prevent duplicate active allocation
    $exists = \App\Models\HostelAllocation::where('student_id', $request->student_id)
        ->where('status', true)
        ->first();

    if ($exists) {
        return back()->withErrors([
            'student_id' => 'This student already has an active hostel allocation.'
        ])->withInput();
    }

    // Check room capacity
    $room = \App\Models\HostelRoom::findOrFail($request->room_id);
    $count = \App\Models\HostelAllocation::where('room_id', $room->id)
        ->where('status', true)
        ->count();

    if ($count >= $room->capacity) {
        return back()->withErrors([
            'room_id' => 'This room is fully occupied.'
        ])->withInput();
    }

    \App\Models\HostelAllocation::create([
        'school_id' => Auth::user()->school_id,
        'student_id' => $request->student_id,
        'hostel_id' => $request->hostel_id,
        'room_id' => $request->room_id,
        'bed_number' => $request->bed_number,
        'allocation_date' => $request->allocation_date,
        'status' => true,
    ]);

    // Update room occupancy
    $room->increment('current_occupancy');

    return redirect()->route('hostel-allocations.index')->with('success', 'Hostel allocation successful.');
}


    public function show(HostelAllocation $hostel_allocation)
    {
        $this->authorizeAccess($hostel_allocation);
        return view('in.school.hostels.hostel_allocations.show', compact('hostel_allocation'));
    }
public function edit(HostelAllocation $hostel_allocation)
{
    $this->authorizeAccess($hostel_allocation);

    $schoolId = Auth::user()->school_id;

    $students = \App\Models\Student::with('user')->where('school_id', $schoolId)->get();
    $hostels = \App\Models\Hostel::where('school_id', $schoolId)->get();
    $rooms = \App\Models\HostelRoom::where('school_id', $schoolId)->get();

    return view('in.school.hostels.hostel_allocations.edit', compact('hostel_allocation', 'students', 'hostels', 'rooms'));
}

    public function update(Request $request, HostelAllocation $hostel_allocation)
{
    $this->authorizeAccess($hostel_allocation);

    $request->validate([
        'student_id' => 'required|exists:students,user_id',
        'hostel_id' => 'required|exists:hostels,id',
        'room_id' => 'required|exists:hostel_rooms,id',
        'bed_number' => 'required|string|max:20',
        'allocation_date' => 'required|date',
        'status' => 'required|boolean',
    ]);

    // Prevent double allocation
    $existing = \App\Models\HostelAllocation::where('student_id', $request->student_id)
        ->where('id', '!=', $hostel_allocation->id)
        ->where('status', true)
        ->first();

    if ($existing) {
        return back()->withErrors([
            'student_id' => 'This student already has an active hostel allocation.'
        ])->withInput();
    }

    // Capacity Check
    $room = \App\Models\HostelRoom::findOrFail($request->room_id);
    $currentCount = \App\Models\HostelAllocation::where('room_id', $room->id)
        ->where('status', true)
        ->where('id', '!=', $hostel_allocation->id)
        ->count();

    if ($currentCount >= $room->capacity) {
        return back()->withErrors([
            'room_id' => 'This room is fully occupied.'
        ])->withInput();
    }

    // Update occupancy if room was changed
    if ($hostel_allocation->room_id != $request->room_id) {
        \App\Models\HostelRoom::find($hostel_allocation->room_id)?->decrement('current_occupancy');
        $room->increment('current_occupancy');
    }

    $hostel_allocation->update($request->only([
        'student_id', 'hostel_id', 'room_id', 'bed_number', 'allocation_date', 'status'
    ]));

    return redirect()->route('hostel-allocations.index')->with('success', 'Hostel allocation updated successfully.');
}


    public function destroy(HostelAllocation $hostel_allocation)
    {
        $this->authorizeAccess($hostel_allocation);

        $room = $hostel_allocation->room;
        $hostel_allocation->delete();

        // Decrease room occupancy
        $room->decrement('current_occupancy');

        return back()->with('success', 'Allocation deleted and room updated.');
    }

    private function authorizeAccess(HostelAllocation $allocation)
    {
        if ($allocation->school_id !== Auth::user()->school_id) {
            abort(403);
        }
    }
}
