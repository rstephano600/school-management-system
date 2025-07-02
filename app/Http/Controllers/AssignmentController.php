<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Classes;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    public function index()
    {
        $schoolId = auth()->user()->school_id;
        $assignments = Assignment::with(['class', 'creator'])
            ->where('school_id', $schoolId)
            ->orderByDesc('due_date')
            ->paginate(20);

        return view('in.school.assignments.index', compact('assignments'));
    }

    public function create()
    {
         $schoolId = auth()->user()->school_id;
        $classes = Classes::where('school_id', $schoolId)->get();
        return view('in.school.assignments.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'title' => 'required|string|max:255',
            'due_date' => 'required|date',
            'max_points' => 'required|numeric|min:0',
            'assignment_type' => 'required|in:homework,quiz,test,other',
            'status' => 'required|in:draft,published,graded',
            'file' => 'nullable|file|max:10240',
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('assignments', 'public');
        }

        Assignment::create([
            'school_id' => auth()->user()->school_id,
            'class_id' => $request->class_id,
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'max_points' => $request->max_points,
            'assignment_type' => $request->assignment_type,
            'status' => $request->status,
            'file' => $filePath,
            'created_by' => 15,
        ]);

        return redirect()->route('assignments.index')->with('success', 'Assignment created successfully.');
    }

    public function show(Assignment $assignment)
    {
        return view('in.school.assignments.show', compact('assignment'));
    }

    public function edit(Assignment $assignment)
    {
        $this->authorize('update', $assignment);
        $classes = Classes::where('school_id', auth()->user()->school_id)->get();
        return view('in.school.assignments.edit', compact('assignment', 'classes'));
    }

    public function update(Request $request, Assignment $assignment)
    {
        $this->authorize('update', $assignment);

        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'title' => 'required|string|max:255',
            'due_date' => 'required|date',
            'max_points' => 'required|numeric|min:0',
            'assignment_type' => 'required|in:homework,quiz,test,other',
            'status' => 'required|in:draft,published,graded',
            'file' => 'nullable|file|max:10240',
        ]);

        if ($request->hasFile('file')) {
            $assignment->file = $request->file('file')->store('assignments', 'public');
        }

        $assignment->update($request->only([
            'class_id', 'title', 'description', 'due_date', 'max_points',
            'assignment_type', 'status', 'file'
        ]));

        return redirect()->route('assignments.index')->with('success', 'Assignment updated successfully.');
    }

    public function destroy(Assignment $assignment)
    {
        $this->authorize('delete', $assignment);
        $assignment->delete();
        return redirect()->route('assignments.index')->with('success', 'Assignment deleted.');
    }
}
