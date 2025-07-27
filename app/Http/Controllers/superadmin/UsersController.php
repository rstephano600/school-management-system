<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\School;
use App\Imports\UsersImport;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{

    public function index(Request $request)
    {
        $query = User::query()->with('school');

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('role', 'like', "%{$search}%");
            });
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(30);

        $userCount = User::count();
        return view('in.superadmin.users.index', compact('users'))->with('userCount', $userCount);
    }

    public function create()
    {
        return view('in.superadmin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|string',
            'status' => 'required|boolean',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('superadmin.users.index')->with('success', 'User created successfully.');
    }

    public function show($id)
    {
        $user = User::with('school')->findOrFail($id);
        return view('in.superadmin.users.show', compact('user'));
    }

    public function edit($id)
{
    $user = User::findOrFail($id);
    $schools = School::all(); // if you want to allow changing school
    $roles = ['school_admin', 'school_creator', 'student', 'super_admin']; // customize as needed

    return view('in.superadmin.users.edit', compact('user', 'schools', 'roles'));
}

public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    $validated = $request->validate([
        'name' => 'required|string|max:50',
        'email' => 'required|email|unique:users,email,' . $id,
        'role' => 'required|string',
        'status' => 'required|boolean',
        'school_id' => 'nullable|exists:schools,id',
    ]);

    $user->update($validated);

    return redirect()->route('superadmin.users.index')
        ->with('success', 'User updated successfully.');
}

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('superadmin.users.index')->with('success', 'User deleted successfully.');
    }

    public function showimport()
    {
        return view('in.superadmin.import.importusers');
    }

    public function import(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,xls']);

        Excel::import(new UsersImport, $request->file('file'));

        return redirect()->back()->with('success', 'Users imported successfully.');
    }

    public function export()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }
}
