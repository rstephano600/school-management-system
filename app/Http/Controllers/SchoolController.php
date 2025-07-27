<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class SchoolController extends Controller
{
    /**
     * Display a listing of schools with search, filter, and pagination
     */
    public function index(Request $request)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        // Only super_admin, school_creator can access schools
        if (!in_array($user->role, ['super_admin', 'school_creator'])) {
            abort(403, 'Unauthorized access');
        }

        $query = School::query();

        // If school_creator, only show schools they created
        if ($user->role === 'school_creator') {
            $query->where('modified_by', $user->id);
        }

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('code', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('city', 'LIKE', "%{$search}%")
                  ->orWhere('state', 'LIKE', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }

        // City filter
        if ($request->filled('city')) {
            $query->where('city', 'LIKE', "%{$request->get('city')}%");
        }

        // State filter
        if ($request->filled('state')) {
            $query->where('state', 'LIKE', "%{$request->get('state')}%");
        }

        // Country filter
        if ($request->filled('country')) {
            $query->where('country', 'LIKE', "%{$request->get('country')}%");
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        
        $allowedSorts = ['name', 'code', 'city', 'state', 'status', 'created_at', 'established_date'];
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortOrder);
        }

        // Get distinct values for filters
        $cities = School::select('city')->distinct()->whereNotNull('city')->pluck('city');
        $states = School::select('state')->distinct()->whereNotNull('state')->pluck('state');
        $countries = School::select('country')->distinct()->whereNotNull('country')->pluck('country');

        // Pagination
        $perPage = $request->get('per_page', 10);
        $schools = $query->paginate($perPage)->withQueryString();

        return view('in.schools.index', compact('schools', 'cities', 'states', 'countries'));
    }

    /**
     * Show the form for creating a new school
     */
public function create()
{
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    $user = Auth::user();

    if (!in_array($user->role, ['super_admin', 'school_creator'])) {
        abort(403, 'Unauthorized access');
    }

    // Define cities (static list or from database)
    $cities = ['Dar es Salaam', 'Arusha', 'Dodoma', 'Mwanza', 'Mbeya'];

    return view('in.schools.create', compact('cities'));
}


    /**
     * Store a newly created school
     */
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        if (!in_array($user->role, ['super_admin', 'school_creator'])) {
            abort(403, 'Unauthorized access');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:schools,code',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255|unique:schools,email',
            'website' => 'nullable|url|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'established_date' => 'nullable|date',
            'status' => 'required|boolean',
        ]);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('school-logos', 'public');
            $validated['logo'] = $logoPath;
        }

        // Set the creator
        $validated['modified_by'] = $user->id;

        $school = School::create($validated);

        return redirect()->route('schools.index')
                        ->with('success', 'School created successfully.');
    }

    /**
     * Display the specified school
     */
    public function show(School $school)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        if (!in_array($user->role, ['super_admin', 'school_creator'])) {
            abort(403, 'Unauthorized access');
        }

        // School_creator can only view their own schools
        if ($user->role === 'school_creator' && $school->modified_by !== $user->id) {
            abort(403, 'You can only view schools you created');
        }

        // Get school statistics
        $stats = [
            'total_users' => $school->users()->count(),
            'active_users' => $school->users()->where('status', 'active')->count(),
            'pending_users' => $school->users()->where('status', 'pending')->count(),
            'teachers' => $school->users()->where('role', 'teacher')->count(),
            'students' => $school->users()->where('role', 'student')->count(),
            'parents' => $school->users()->where('role', 'parent')->count(),
        ];

        return view('in.schools.show', compact('school', 'stats'));
    }

    /**
     * Show the form for editing the specified school
     */
    public function edit(School $school)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        if (!in_array($user->role, ['super_admin', 'school_creator'])) {
            abort(403, 'Unauthorized access');
        }

        // School_creator can only edit their own schools
        if ($user->role === 'school_creator' && $school->modified_by !== $user->id) {
            abort(403, 'You can only edit schools you created');
        }

        return view('in.schools.edit', compact('school'));
    }

    /**
     * Update the specified school
     */
    public function update(Request $request, School $school)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        if (!in_array($user->role, ['super_admin', 'school_creator'])) {
            abort(403, 'Unauthorized access');
        }

        // School_creator can only update their own schools
        if ($user->role === 'school_creator' && $school->modified_by !== $user->id) {
            abort(403, 'You can only update schools you created');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('schools', 'code')->ignore($school->id)
            ],
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'phone' => 'nullable|string|max:20',
            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('schools', 'email')->ignore($school->id)
            ],
            'website' => 'nullable|url|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'established_date' => 'nullable|date',
            'status' => 'required|boolean',
        ]);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($school->logo && Storage::disk('public')->exists($school->logo)) {
                Storage::disk('public')->delete($school->logo);
            }
            
            $logoPath = $request->file('logo')->store('school-logos', 'public');
            $validated['logo'] = $logoPath;
        }

        $school->update($validated);

        return redirect()->route('schools.index')
                        ->with('success', 'School updated successfully.');
    }

    /**
     * Remove the specified school
     */
    public function destroy(School $school)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        if (!in_array($user->role, ['super_admin', 'school_creator'])) {
            abort(403, 'Unauthorized access');
        }

        // School_creator can only delete their own schools
        if ($user->role === 'school_creator' && $school->modified_by !== $user->id) {
            abort(403, 'You can only delete schools you created');
        }

        // Check if school has users
        if ($school->users()->count() > 0) {
            return redirect()->route('schools.index')
                            ->with('error', 'Cannot delete school with existing users. Please remove all users first.');
        }

        // Delete logo if exists
        if ($school->logo && Storage::disk('public')->exists($school->logo)) {
            Storage::disk('public')->delete($school->logo);
        }

        $school->delete();

        return redirect()->route('schools.index')
                        ->with('success', 'School deleted successfully.');
    }

    /**
     * Toggle school status
     */
    public function toggleStatus(School $school)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        if (!in_array($user->role, ['super_admin', 'school_creator'])) {
            abort(403, 'Unauthorized access');
        }

        // School_creator can only toggle status of their own schools
        if ($user->role === 'school_creator' && $school->modified_by !== $user->id) {
            abort(403, 'You can only manage schools you created');
        }

        $school->update(['status' => !$school->status]);

        $status = $school->status ? 'activated' : 'deactivated';
        
        return redirect()->back()
                        ->with('success', "School {$status} successfully.");
    }

    /**
     * Get schools data for AJAX requests
     */
    public function getData(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = Auth::user();
        
        if (!in_array($user->role, ['super_admin', 'school_creator'])) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        $query = School::query();

        // If school_creator, only show schools they created
        if ($user->role === 'school_creator') {
            $query->where('modified_by', $user->id);
        }

        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('code', 'LIKE', "%{$search}%");
            });
        }

        $schools = $query->select('id', 'name', 'code', 'status')
                        ->limit(20)
                        ->get();

        return response()->json($schools);
    }
}