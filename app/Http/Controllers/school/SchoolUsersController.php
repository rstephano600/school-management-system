<?php

namespace App\Http\Controllers\school;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\School;

class SchoolUsersController extends Controller
{

    public function index(Request $request) 
{
    $schoolId = auth()->user()->school_id;

    // Start query using students table and disambiguate school_id
    $query = User::query()
        ->where('users.school_id', $schoolId);

if ($request->filled('search')) {
    $search = $request->input('search');
    $query->where(function($q) use ($search) {
        $q->where('name', 'like', "%{$search}%")
          ->orWhere('email', 'like', "%{$search}%");
    });
}


    // Sorting logic
    $sort = $request->input('sort', 'name');
    $direction = $request->input('direction', 'asc');

    if ($sort === 'name') {
        // Join with users table for name sorting
        $query->orderBy('users.name', $direction)
              ->select('users.*'); // Prevent selecting user.* accidentally
    } elseif ($sort === 'created_at') {
        $query->orderBy('users.created_at', $direction);
    }

    // Pagination
$users = $query->paginate(10)->appends($request->query());

return view('in.school.users.index', compact('users', 'sort', 'direction'));

}

public function create()
{
    return view('in.school.users.create');
}

  public function store(Request $request)
    {
        $schoolId = auth()->user()->school_id;
        $request->validate([
            'email' => 'required|email|unique:users',
            'role' => 'required|in:student,parent,teacher,school_admin,academic_master,director,manager,head_master,secretary,staff,school_doctor,school_librarian',
            'name' => 'required',
        ]);

        $user = new User();
        $user->email = $request->email;
        $user->role = $request->role;
        $user->name = $request->name;
        $user->password = bcrypt('12345678');
        $user->school_id = $schoolId;
        $user->save();

        return redirect()->route('users.create')
                         ->with('success', 'User registered successfully ');
    }


    public function show(Request $request, User $user)
    {
    return view('in.school.users.show', compact('user'));
}


}
