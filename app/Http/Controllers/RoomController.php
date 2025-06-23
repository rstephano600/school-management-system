<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::where('school_id', auth()->user()->school_id)->paginate(20);
        return view('in.school.rooms.index', compact('rooms'));
    }

    public function create()
    {
        return view('in.school.rooms.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'number' => 'required|string|max:20',
            'name' => 'nullable|string|max:100',
            'building' => 'required|string|max:100',
            'floor' => 'required|string|max:10',
            'capacity' => 'required|integer|min:1',
            'room_type' => 'required|in:classroom,lab,office,library,other',
            
        ]);

        Room::create(array_merge($validated, [
            'school_id' => auth()->user()->school_id,
            'user_id' => auth()->id(),
            'status' => '1',
        ]));

        return redirect()->route('rooms.index')->with('success', 'Room created successfully.');
    }

    public function edit(Room $room)
    {
        if ($room->school_id !== auth()->user()->school_id) abort(403);
        return view('in.school.rooms.edit', compact('room'));
    }

    public function update(Request $request, Room $room)
    {
        if ($room->school_id !== auth()->user()->school_id) abort(403);

        $validated = $request->validate([
            'number' => 'required|string|max:20',
            'name' => 'nullable|string|max:100',
            'building' => 'required|string|max:100',
            'floor' => 'required|string|max:10',
            'capacity' => 'required|integer|min:1',
            'room_type' => 'required|in:classroom,lab,office,library,other',
        ]);

        $room->update(array_merge($validated, [
            'status' => '1',
        ]));

        return redirect()->route('rooms.index')->with('success', 'Room updated successfully.');
    }

    public function destroy(Room $room)
    {
        if ($room->school_id !== auth()->user()->school_id) abort(403);
        $room->delete();
        return redirect()->route('rooms.index')->with('success', 'Room deleted.');
    }
}
