<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    public function index(Request $request)
    {
        $schoolId = Auth::user()->school_id;

        $query = Announcement::where('school_id', $schoolId);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('audience', 'like', "%{$search}%");
            });
        }

        $announcements = $query->orderBy('start_date', 'desc')->paginate(10);

        return view('in.school.announcements.index', compact('announcements'));
    }

    public function create()
    {
        return view('in.school.announcements.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'audience' => 'required|in:all,teachers,students,parents,staff',
            'status' => 'required|in:draft,published',
        ]);

        Announcement::create([
            'school_id' => Auth::user()->school_id,
            'title' => $request->title,
            'content' => $request->content,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'audience' => $request->audience,
            'status' => $request->status,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('announcements.index')->with('success', 'Announcement created.');
    }

    public function show(Announcement $announcement)
    {
        $this->authorizeAccess($announcement);
        return view('in.school.announcements.show', compact('announcement'));
    }

    public function edit(Announcement $announcement)
    {
        $this->authorizeAccess($announcement);
        return view('in.school.announcements.edit', compact('announcement'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $this->authorizeAccess($announcement);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'audience' => 'required|in:all,teachers,students,parents,staff',
            'status' => 'required|in:draft,published,archived',
        ]);

        $announcement->update($request->only([
            'title', 'content', 'start_date', 'end_date',
            'audience', 'status'
        ]));

        return redirect()->route('announcements.index')->with('success', 'Announcement updated.');
    }

    public function destroy(Announcement $announcement)
    {
        $this->authorizeAccess($announcement);
        $announcement->delete();
        return back()->with('success', 'Announcement deleted.');
    }

    private function authorizeAccess(Announcement $announcement)
    {
        if ($announcement->school_id !== Auth::user()->school_id) {
            abort(403);
        }
    }
}
