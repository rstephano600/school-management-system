<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\School;
use App\Models\User;


class SchoolController extends Controller
{
    public function index()
    {
        $schools = School::all();
        return view('in.superadmin.schools.index', compact('schools'));
    }

    public function create()
    {
        return view('in.superadmin.schools.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:schools',
            'code' => 'required|string|max:50|unique:schools',
            'address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'country' => 'required|string',
            'postal_code' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email',
            'website' => 'nullable|url',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg',
            'established_date' => 'required|date',
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $validated['modified_by'] = auth()->id();

        School::create($validated);

        return redirect()->route('superadmin.schools')->with('success', 'School created successfully.');
    }

    public function edit(School $school)
    {
        return view('in.superadmin.schools.edit', compact('school'));
    }

    public function update(Request $request, School $school)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:schools,name,' . $school->id,
            'code' => 'required|string|max:50|unique:schools,code,' . $school->id,
            'address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'country' => 'required|string',
            'postal_code' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email',
            'website' => 'nullable|url',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg',
            'established_date' => 'required|date',
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $school->update($validated);

        return redirect()->route('superadmin.schools.index')->with('success', 'School updated successfully.');
    }

    public function destroy(School $school)
    {
        $school->delete();
        return back()->with('success', 'School deleted.');
    }


    public function show(School $school)
    {
    $totalUsers = $school->users()->count();
    $totalStudents = $school->users()->where('role', 'student')->count();
    $totalParents = $school->users()->where('role', 'parent')->count();

    // Assuming you have relations for these
    // $library = $school->library;
    // $health = $school->health;
    // $activities = $school->activities;

    return view('in.superadmin.schools.show', compact(
        'school', 'totalUsers', 'totalStudents', 'totalParents'
    ));
    }

// , 'library', 'health', 'activities'




public function showUsers(School $school, Request $request)
{
    $query = $school->users();

    if ($request->has('role')) {
        $query->where('role', $request->role);
    }

    if ($request->has('search')) {
        $query->where(function ($q) use ($request) {
            $q->where('name', 'like', '%'.$request->search.'%')
              ->orWhere('email', 'like', '%'.$request->search.'%');
        });
    }

    $users = $query->paginate(10); // Laravel pagination

    return view('in.superadmin.schools.user-list', [
        'school' => $school,
        'users' => $users,
        'filterRole' => $request->role,
        'searchTerm' => $request->search,
    ]);
}







}
