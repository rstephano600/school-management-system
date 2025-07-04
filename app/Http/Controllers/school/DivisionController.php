<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DivisionController extends Controller
{
    // Display a listing of the divisions
    public function index(Request $request)
    {
        $query = Division::with('school');

        // Apply school_id restriction based on user role
        if (Auth::user()->role !== 'superadmin') {
            $query->where('school_id', Auth::user()->school_id);
        }

        // Apply search and filter
        if ($request->filled('search')) {
            $query->where('division', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('school_id')) {
            $query->where('school_id', $request->school_id);
        }

        $divisions = $query->orderBy('min_point')->paginate(10);
        $schools = School::all();

        return view('in.school.divisions.index', compact('divisions', 'schools'));
    }

    // Show the form for creating a new division
    public function create()
    {
        $schools = School::all();
        return view('in.school.divisions.create', compact('schools'));
    }

    // Store a newly created division
        public function store(Request $request)
    {
        $validated = $request->validate([
            'min_point' => 'required|numeric',
            'max_point' => 'required|numeric|gte:min_point',
            'division' => 'required|string|max:255',
            'remarks' => 'nullable|string|max:255',
        ]);

        $validated['school_id'] = auth()->user()->school_id;
        $validated['created_by'] = auth()->id();
        Division::create($validated);
        return redirect()->route('divisions.index')->with('success', 'Division created successfully.');
    }

    public function show(Division $division)
{
    $this->authorizeSchoolAccess($division->school_id);

    return view('in.school.divisions.show', compact('division'));
}

    // Show the form for editing the specified division
    public function edit(Division $division)
    {
        $this->authorizeSchoolAccess($division->school_id);

        $schools = School::all();
        return view('in.school.divisions.edit', compact('division', 'schools'));
    }

    // Update the specified division
    public function update(Request $request, Division $division)
    {
        $this->authorizeSchoolAccess($division->school_id);

        $request->validate([
            'school_id' => 'required|exists:schools,id',
            'min_point' => 'required|numeric',
            'max_point' => 'required|numeric|gte:min_point',
            'division' => 'required|string|max:255',
            'remarks' => 'nullable|string|max:255',
        ]);

        $division->update([
            'school_id' => $request->school_id,
            'min_point' => $request->min_point,
            'max_point' => $request->max_point,
            'division' => $request->division,
            'remarks' => $request->remarks,
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('divisions.index')->with('success', 'Division updated successfully.');
    }

    // Delete the specified division
    public function destroy(Division $division)
    {
        $this->authorizeSchoolAccess($division->school_id);
        $division->delete();

        return redirect()->route('divisions.index')->with('success', 'Division deleted successfully.');
    }

    // Helper function for school-based access control
    protected function authorizeSchoolAccess($schoolId)
    {
        if (Auth::user()->role !== 'superadmin' && Auth::user()->school_id !== $schoolId) {
            abort(403, 'Unauthorized access to this school\'s data.');
        }
    }
}
