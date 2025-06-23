<?php

namespace App\Http\Controllers;

use App\Models\HostelRoom;
use App\Models\Hostel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HostelRoomController extends Controller
{
    public function index(Request $request)
    {
        $schoolId = Auth::user()->school_id;

        $query = HostelRoom::with('hostel')
            ->where('school_id', $schoolId);

        if ($request->filled('search')) {
            $query->where('room_number', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('room_type')) {
            $query->where('room_type', $request->room_type);
        }

        $rooms = $query->orderBy('room_number')->paginate(10);

        return view('in.school.hostels.hostel_rooms.index', compact('rooms'));
    }

    public function create()
    {
        $hostels = Hostel::where('school_id', Auth::user()->school_id)->get();
        return view('in.school.hostels.hostel_rooms.create', compact('hostels'));
    }

public function store(Request $request)
{
    $request->validate([
        'hostel_id' => 'required|exists:hostels,id',
        'room_number' => 'required|string|max:20',
        'room_type' => 'required|in:single,double,dormitory,other',
        'capacity' => 'required|integer|min:1',
        'cost_per_bed' => 'required|numeric|min:0',
        'status' => 'required|in:available,occupied,maintenance',
    ]);

    $hostel = Hostel::findOrFail($request->hostel_id);

    // Calculate total existing capacity already assigned to rooms in this hostel
    $totalAssigned = HostelRoom::where('hostel_id', $hostel->id)->sum('capacity');

    // Calculate remaining capacity
    $remainingCapacity = $hostel->capacity - $totalAssigned;

    // Check if requested room capacity exceeds what's left
    if ($request->capacity > $remainingCapacity) {
        return back()->withErrors([
            'capacity' => "Cannot assign {$request->capacity} more beds. Only {$remainingCapacity} beds available in this hostel."
        ])->withInput();
    }

    // Proceed with creation
    HostelRoom::create([
        'school_id' => Auth::user()->school_id,
        'hostel_id' => $request->hostel_id,
        'room_number' => $request->room_number,
        'room_type' => $request->room_type,
        'capacity' => $request->capacity,
        'cost_per_bed' => $request->cost_per_bed,
        'status' => $request->status,
    ]);

    return redirect()->route('hostel-rooms.index')->with('success', 'Hostel room created successfully.');
}


    public function show(HostelRoom $hostel_room)
    {
        $this->authorizeRoom($hostel_room);
        return view('in.school.hostels.hostel_rooms.show', compact('hostel_room'));
    }

    public function edit(HostelRoom $hostel_room)
    {
        $this->authorizeRoom($hostel_room);
        $hostels = Hostel::where('school_id', Auth::user()->school_id)->get();
        return view('in.school.hostels.hostel_rooms.edit', compact('hostel_room', 'hostels'));
    }

    public function update(Request $request, HostelRoom $hostel_room)
{
    $this->authorizeRoom($hostel_room);

    $request->validate([
        'room_number' => 'required|string|max:20',
        'room_type' => 'required|in:single,double,dormitory,other',
        'capacity' => 'required|integer|min:1',
        'cost_per_bed' => 'required|numeric|min:0',
        'status' => 'required|in:available,occupied,maintenance',
    ]);

    $hostel = $hostel_room->hostel;

    // Sum all rooms in this hostel excluding the current room
    $totalOtherRooms = \App\Models\HostelRoom::where('hostel_id', $hostel->id)
        ->where('id', '!=', $hostel_room->id)
        ->sum('capacity');

    // Remaining capacity = total hostel capacity - total capacity of other rooms
    $remainingCapacity = $hostel->capacity - $totalOtherRooms;

    // If new capacity exceeds what's available, reject update
    if ($request->capacity > $remainingCapacity) {
        return back()->withErrors([
            'capacity' => "Cannot assign {$request->capacity} beds. Only {$remainingCapacity} beds are available in this hostel."
        ])->withInput();
    }

    $hostel_room->update($request->only([
        'room_number',
        'room_type',
        'capacity',
        'cost_per_bed',
        'status',
    ]));

    return redirect()->route('hostel-rooms.index')->with('success', 'Hostel room updated successfully.');
}

    public function destroy(HostelRoom $hostel_room)
    {
        $this->authorizeRoom($hostel_room);
        $hostel_room->delete();
        return back()->with('success', 'Room deleted.');
    }

    private function authorizeRoom(HostelRoom $room)
    {
        if ($room->school_id !== Auth::user()->school_id) {
            abort(403);
        }
    }
}
