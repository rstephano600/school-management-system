<?php


namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Teacher;

class SubjectController extends Controller
{
    public function index()
    {
        $schoolId = auth()->user()->school_id;

        $subjects = Subject::with('teachers')
            ->where('school_id', $schoolId)
            ->orderBy('name')
            ->paginate(20);

        return view('in.school.subjects.index', compact('subjects'));
    }

    public function create()
    {
        $schoolId = auth()->user()->school_id;



$teachers = Teacher::with('user')
    ->where('school_id', auth()->user()->school_id)
    ->where('status', true)
    ->get();



        return view('in.school.subjects.create', compact('teachers'));
    }

    public function store(Request $request)
    {
        $schoolId = auth()->user()->school_id;

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'code' => 'required|string|max:20|unique:subject,code',
            'description' => 'nullable|string',
            'is_core' => 'nullable|boolean',
            'teacher_ids' => 'nullable|array',
            'teacher_ids.*' => 'exists:users,id',
        ]);

        // Filter teachers to only those in this school
        $teacherIds = User::where('school_id', $schoolId)
            ->whereIn('id', $request->teacher_ids ?? [])
            ->pluck('id')
            ->toArray();

        $subject = Subject::create([
            'name' => $validated['name'],
            'code' => $validated['code'],
            'description' => $validated['description'] ?? null,
            'is_core' => $request->has('is_core'),
            'school_id' => $schoolId,
            'user_id' => auth()->id(),
        ]);

        $subject->teachers()->sync($teacherIds);

        return redirect()->route('subjects.index')->with('success', 'Subject created successfully.');
    }

    public function show(Subject $subject)
    {
        $this->authorizeAccess($subject);

        $subject->load('teachers');

        return view('in.school.subjects.show', compact('subject'));
    }

    public function edit(Subject $subject)
    {
        $this->authorizeAccess($subject);

        $schoolId = auth()->user()->school_id;

$teachers = Teacher::with('user')
    ->where('school_id', auth()->user()->school_id)
    ->where('status', true)
    ->get();


        return view('in.school.subjects.edit', compact('subject', 'teachers'));
    }

    public function update(Request $request, Subject $subject)
    {
        $this->authorizeAccess($subject);

        $schoolId = auth()->user()->school_id;

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'code' => 'required|string|max:20|unique:subject,code,' . $subject->id,
            'description' => 'nullable|string',
            'is_core' => 'nullable|boolean',
            'teacher_ids' => 'nullable|array',
            'teacher_ids.*' => 'exists:users,id',
        ]);

        // Filter only this school's teachers
        $teacherIds = User::where('school_id', $schoolId)
            ->whereIn('id', $request->teacher_ids ?? [])
            ->pluck('id')
            ->toArray();

        $subject->update([
            'name' => $validated['name'],
            'code' => $validated['code'],
            'description' => $validated['description'] ?? null,
            'is_core' => $request->has('is_core'),
        ]);

        $subject->teachers()->sync($teacherIds);

        return redirect()->route('subjects.index')->with('success', 'Subject updated successfully.');
    }

    public function destroy(Subject $subject)
    {
        $this->authorizeAccess($subject);

        $subject->teachers()->detach();
        $subject->delete();

        return redirect()->route('subjects.index')->with('success', 'Subject deleted.');
    }

    /**
     * Ensure the subject belongs to the current user's school.
     */
    private function authorizeAccess(Subject $subject)
    {
        if ($subject->school_id !== auth()->user()->school_id) {
            abort(403, 'Unauthorized access.');
        }
    }
}
