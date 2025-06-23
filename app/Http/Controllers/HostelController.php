<?php

namespace App\Http\Controllers;

use App\Models\Hostel;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HostelController extends Controller
{
public function index(Request $request)
{
    $schoolId = Auth::user()->school_id;

    $query = Hostel::with('warden.user')
        ->where('school_id', $schoolId);

    if ($request->filled('search')) {
        $query->where('name', 'like', '%' . $request->search . '%');
    }

    if ($request->filled('type')) {
        $query->where('type', $request->type);
    }

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    $hostels = $query->orderBy('name')->paginate(10);

    return view('in.school.hostels.index', compact('hostels'));
}

    public function create()
    {
        $wardens = Staff::where('school_id', Auth::user()->school_id)->get();
        return view('in.school.hostels.create', compact('wardens'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:boys,girls,co-ed',
            'address' => 'required|string',
            'contact_number' => 'required|string|max:20',
            'capacity' => 'required|integer|min:1',
            'warden_id' => 'nullable|exists:staff,user_id',
            'description' => 'nullable|string',
        ]);

        Hostel::create([
            'school_id' => Auth::user()->school_id,
            'name' => $request->name,
            'type' => $request->type,
            'address' => $request->address,
            'contact_number' => $request->contact_number,
            'capacity' => $request->capacity,
            'warden_id' => $request->warden_id,
            'description' => $request->description,
            'status' => true,
        ]);

        return redirect()->route('hostels.index')->with('success', 'Hostel created successfully.');
    }

    public function show(Hostel $hostel)
    {
        $this->authorizeHostel($hostel);
        return view('in.school.hostels.show', compact('hostel'));
    }

    public function edit(Hostel $hostel)
    {
        $this->authorizeHostel($hostel);
        $wardens = Staff::where('school_id', Auth::user()->school_id)->get();
        return view('in.school.hostels.edit', compact('hostel', 'wardens'));
    }

    public function update(Request $request, Hostel $hostel)
    {
        $this->authorizeHostel($hostel);

        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:boys,girls,co-ed',
            'address' => 'required|string',
            'contact_number' => 'required|string|max:20',
            'capacity' => 'required|integer|min:1',
            'warden_id' => 'nullable|exists:staff,user_id',
            'description' => 'nullable|string',
        ]);

        $hostel->update($request->only([
            'name', 'type', 'address', 'contact_number', 'capacity', 'warden_id', 'description'
        ]));

        return redirect()->route('hostels.index')->with('success', 'Hostel updated.');
    }

    public function destroy(Hostel $hostel)
    {
        $this->authorizeHostel($hostel);
        $hostel->delete();
        return back()->with('success', 'Hostel deleted.');
    }

    private function authorizeHostel(Hostel $hostel)
    {
        if ($hostel->school_id !== Auth::user()->school_id) {
            abort(403);
        }
    }
}
