<?php
namespace App\Http\Controllers;

use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class NoticeController extends Controller
{
    public function index()
    {
        $schoolId = Auth::user()->school_id;
        $notices = Notice::where('school_id', $schoolId)->latest()->paginate(10);
        return view('in.school.notices.index', compact('notices'));
    }

    public function create()
    {
        return view('in.school.notices.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'topic' => 'nullable|string|max:255',
            'notice_date' => 'required|date',
            'audience' => 'required|in:all,teachers,students,parents,staff',
            'status' => 'required|in:draft,published,archived',
            'content' => 'required|file|mimes:pdf,doc,docx|max:512',
        ]);

        $path = $request->file('content')->store('notices', 'public');

        Notice::create([
            'school_id' => Auth::user()->school_id,
            'title' => $request->title,
            'topic' => $request->topic,
            'notice_date' => $request->notice_date,
            'audience' => $request->audience,
            'status' => $request->status,
            'content' => $path,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('notices.index')->with('success', 'Notice uploaded.');
    }

    public function show(Notice $notice)
    {
        $this->authorizeSchool($notice);
        return view('in.school.notices.show', compact('notice'));
    }

    public function edit(Notice $notice)
    {
        $this->authorizeSchool($notice);
        return view('in.school.notices.edit', compact('notice'));
    }

    public function update(Request $request, Notice $notice)
    {
        $this->authorizeSchool($notice);

        $request->validate([
            'title' => 'required|string|max:255',
            'topic' => 'nullable|string|max:255',
            'notice_date' => 'required|date',
            'audience' => 'required|in:all,teachers,students,parents,staff',
            'status' => 'required|in:draft,published,archived',
            'content' => 'nullable|file|mimes:pdf,doc,docx|max:512',
        ]);

        $data = $request->only(['title', 'topic', 'notice_date', 'audience', 'status']);

        if ($request->hasFile('content')) {
            // Delete old file if exists
            if ($notice->content) {
                Storage::disk('public')->delete($notice->content);
            }
            $data['content'] = $request->file('content')->store('notices', 'public');
        }

        $notice->update($data);

        return redirect()->route('notices.index')->with('success', 'Notice updated.');
    }

    public function destroy(Notice $notice)
    {
        $this->authorizeSchool($notice);

        if ($notice->content) {
            Storage::disk('public')->delete($notice->content);
        }

        $notice->delete();

        return back()->with('success', 'Notice deleted.');
    }

    private function authorizeSchool(Notice $notice)
    {
        if ($notice->school_id !== Auth::user()->school_id) {
            abort(403, 'Unauthorized access');
        }
    }
}
