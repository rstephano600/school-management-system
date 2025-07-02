<?php
namespace App\Http\Controllers;

use App\Models\ExamType;
use Illuminate\Http\Request;

class ExamTypeController extends Controller
{
    public function index()
    {
        $schoolId = auth()->user()->school_id;
        $examTypes = ExamType::where('school_id', $schoolId)
                        ->orderBy('name')->paginate(15);

        return view('in.school.exam_types.index', compact('examTypes'));
    }

    public function create()
    {
        return view('in.school.exam_types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:exam_types,name,NULL,id,school_id,' . auth()->user()->school_id,
            'description' => 'nullable|string',
            'weight' => 'required|numeric|min:0|max:100',
        ]);

        ExamType::create([
            'school_id' => auth()->user()->school_id,
            'name' => $request->name,
            'description' => $request->description,
            'weight' => $request->weight,
        ]);

        return redirect()->route('exam-types.index')->with('success', 'Exam type created successfully.');
    }

    public function show(ExamType $examType)
    {
        $this->authorizeAccess($examType);
        return view('in.school.exam_types.show', compact('examType'));
    }

    public function edit(ExamType $examType)
    {
        $this->authorizeAccess($examType);
        return view('in.school.exam_types.edit', compact('examType'));
    }

    public function update(Request $request, ExamType $examType)
    {
        $this->authorizeAccess($examType);

        $request->validate([
            'name' => 'required|string|max:100|unique:exam_types,name,' . $examType->id . ',id,school_id,' . auth()->user()->school_id,
            'description' => 'nullable|string',
            'weight' => 'required|numeric|min:0|max:100',
        ]);

        $examType->update([
            'name' => $request->name,
            'description' => $request->description,
            'weight' => $request->weight,
        ]);

        return redirect()->route('exam-types.index')->with('success', 'Exam type updated successfully.');
    }

    public function destroy(ExamType $examType)
    {
        $this->authorizeAccess($examType);
        $examType->delete();
        return redirect()->route('exam-types.index')->with('success', 'Exam type deleted.');
    }

    private function authorizeAccess(ExamType $examType)
    {
        if ($examType->school_id !== auth()->user()->school_id && auth()->user()->role !== 'superadmin') {
            abort(403);
        }
    }
}
