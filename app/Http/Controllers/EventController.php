<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
public function index(Request $request)
{
    $schoolId = Auth::user()->school_id;

    $query = Event::where('school_id', $schoolId);

    if ($request->filled('search')) {
        $searchTerm = $request->search;
        $query->where(function ($q) use ($searchTerm) {
            $q->where('title', 'like', "%{$searchTerm}%")
              ->orWhere('event_type', 'like', "%{$searchTerm}%")
              ->orWhere('audience', 'like', "%{$searchTerm}%");
        });
    }

    $events = $query->orderBy('start_datetime', 'desc')->paginate(10);

    return view('in.school.events.index', compact('events'));
}


    public function create()
    {
        return view('in.school.events.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'start_datetime' => 'required|date',
            'end_datetime' => 'required|date|after_or_equal:start_datetime',
            'event_type' => 'required|in:academic,holiday,meeting,sports,cultural,other',
            'audience' => 'required|in:all,teachers,students,parents,staff',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        Event::create([
            'school_id' => Auth::user()->school_id,
            'title' => $request->title,
            'description' => $request->description,
            'start_datetime' => $request->start_datetime,
            'end_datetime' => $request->end_datetime,
            'location' => $request->location,
            'event_type' => $request->event_type,
            'audience' => $request->audience,
            'status' => 'scheduled',
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('events.index')->with('success', 'Event created successfully.');
    }

    public function show(Event $event)
    {
        $this->authorizeEvent($event);
        return view('in.school.events.show', compact('event'));
    }

    public function edit(Event $event)
    {
        $this->authorizeEvent($event);
        return view('in.school.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $this->authorizeEvent($event);

        $request->validate([
            'title' => 'required|string|max:255',
            'start_datetime' => 'required|date',
            'end_datetime' => 'required|date|after_or_equal:start_datetime',
            'event_type' => 'required|in:academic,holiday,meeting,sports,cultural,other',
            'audience' => 'required|in:all,teachers,students,parents,staff',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $event->update($request->only([
            'title', 'description', 'start_datetime', 'end_datetime',
            'location', 'event_type', 'audience'
        ]));

        return redirect()->route('events.index')->with('success', 'Event updated.');
    }

    public function destroy(Event $event)
    {
        $this->authorizeEvent($event);
        $event->delete();
        return back()->with('success', 'Event deleted.');
    }

    private function authorizeEvent(Event $event)
    {
        if ($event->school_id !== Auth::user()->school_id) {
            abort(403, 'Unauthorized');
        }
    }
}
