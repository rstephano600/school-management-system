<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use App\Models\Assignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SubmissionController extends Controller
{
    public function index()
    {
        $schoolId = auth()->user()->school_id;
        $submissions = Submission::with(['assignment', 'student', 'grader'])
            ->where('school_id', $schoolId)
            ->latest('submission_date')
            ->paginate(20);

        return view('in.school.submissions.index', compact('submissions'));
    }

    public function create()
    {
        $assignments = Assignment::where('school_id', auth()->user()->school_id)->get();
        return view('in.school.submissions.create', compact('assignments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'assignment_id' => 'required|exists:assignments,id',
            'file' => 'nullable|file|max:10240',
            'notes' => 'nullable|string',
        ]);

        $assignment = Assignment::findOrFail($request->assignment_id);

        $existing = Submission::where('assignment_id', $assignment->id)
            ->where('student_id', auth()->user()->id)
            ->first();

        if ($existing) {
            return redirect()->back()->withErrors(['You have already submitted this assignment.']);
        }

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('submissions', 'public');
        }

        Submission::create([
            'school_id' => auth()->user()->school_id,
            'assignment_id' => $assignment->id,
            'student_id' => auth()->user()->id,
            'submission_date' => now(),
            'file' => $filePath,
            'notes' => $request->notes,
            'status' => now() > $assignment->due_date ? 'late' : 'submitted',
        ]);

        return redirect()->route('submissions.index')->with('success', 'Submission uploaded successfully.');
    }

    public function show(Submission $submission)
    {
        $this->authorize('view', $submission);
        return view('in.school.submissions.show', compact('submission'));
    }

    public function destroy(Submission $submission)
    {
        $this->authorize('delete', $submission);
        if ($submission->file) {
            Storage::disk('public')->delete($submission->file);
        }
        $submission->delete();

        return redirect()->route('submissions.index')->with('success', 'Submission deleted.');
    }
}
