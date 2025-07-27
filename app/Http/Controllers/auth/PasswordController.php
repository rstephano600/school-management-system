<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Show the form for changing own password
     */
    public function showChangePasswordForm()
    {
        return view('auth.change-password');
    }

    /**
     * Change user's own password
     */
    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', Password::min(8)->letters()->mixedCase()->numbers()->symbols(), 'confirmed'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = Auth::user();

        // Check if current password is correct
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()
                ->withErrors(['current_password' => 'The current password is incorrect.'])
                ->withInput();
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->back()->with('success', 'Password changed successfully!');
    }

    /**
     * Show the form for admin password reset
     */
public function showAdminResetForm(Request $request)
{
    $user = Auth::user();
    $users = collect();
    $search = $request->get('search', '');
    $roleFilter = $request->get('role', '');
    $statusFilter = $request->get('status', '');
    $schoolFilter = $request->get('school', '');

    if ($user->isSuperAdmin()) {
        // Super admin can reset any user's password
        $query = User::with('school')->orderBy('name');
        
        // Apply search filter
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%')
                  ->orWhere('email', 'LIKE', '%' . $search . '%')
                  ->orWhereHas('school', function($schoolQuery) use ($search) {
                      $schoolQuery->where('name', 'LIKE', '%' . $search . '%');
                  });
            });
        }
        
        // Apply role filter
        if (!empty($roleFilter)) {
            $query->where('role', $roleFilter);
        }
        
        // Apply status filter
        if (!empty($statusFilter)) {
            $query->where('status', $statusFilter);
        }
        
        // Apply school filter
        if (!empty($schoolFilter)) {
            $query->where('school_id', $schoolFilter);
        }
        
        $users = $query->get();
        
        // Get all schools for filter dropdown (Super Admin only)
        $schools = \App\Models\School::orderBy('name')->get();
        
    } elseif ($user->isSchoolAdmin()) {
        // School admin can only reset passwords for users in their school
        $query = User::where('school_id', $user->school_id)
            ->with('school')
            ->orderBy('name');
            
        // Apply search filter
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%')
                  ->orWhere('email', 'LIKE', '%' . $search . '%');
            });
        }
        
        // Apply role filter
        if (!empty($roleFilter)) {
            $query->where('role', $roleFilter);
        }
        
        // Apply status filter
        if (!empty($statusFilter)) {
            $query->where('status', $statusFilter);
        }
        
        $users = $query->get();
        $schools = collect(); // School admin doesn't need school filter
        
    } else {
        abort(403, 'Unauthorized action.');
    }

    // Get available roles for filter dropdown
    $availableRoles = $users->pluck('role')->unique()->sort()->values();
    
    // Get available statuses for filter dropdown
    $availableStatuses = $users->pluck('status')->unique()->sort()->values();

    return view('admin.password-reset', compact(
        'users', 
        'search', 
        'roleFilter', 
        'statusFilter', 
        'schoolFilter',
        'schools',
        'availableRoles',
        'availableStatuses'
    ));
}

    /**
     * Reset user password by admin
     */
    public function adminResetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => ['required', 'exists:users,id'],
            'password' => ['required', 'string', Password::min(8)->letters()->mixedCase()->numbers()->symbols(), 'confirmed'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $currentUser = Auth::user();
        $targetUser = User::findOrFail($request->user_id);

        // Check permissions
        if ($currentUser->isSuperAdmin()) {
            // Super admin can reset any user's password
        } elseif ($currentUser->isSchoolAdmin()) {
            // School admin can only reset passwords for users in their school
            if ($targetUser->school_id !== $currentUser->school_id) {
                abort(403, 'You can only reset passwords for users in your school.');
            }
        } else {
            abort(403, 'Unauthorized action.');
        }

        // Prevent resetting super admin password by school admin
        if ($currentUser->isSchoolAdmin() && $targetUser->isSuperAdmin()) {
            abort(403, 'You cannot reset a super admin password.');
        }

        // Update password
        $targetUser->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->back()->with('success', "Password for {$targetUser->name} has been reset successfully!");
    }

    /**
     * Generate random password for admin reset
     */
    public function generatePassword()
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*';
        $password = '';
        $length = 12;

        for ($i = 0; $i < $length; $i++) {
            $password .= $characters[random_int(0, strlen($characters) - 1)];
        }

        return response()->json(['password' => $password]);
    }

    /**
     * Bulk password reset for multiple users
     */
    public function bulkResetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_ids' => ['required', 'array', 'min:1'],
            'user_ids.*' => ['exists:users,id'],
            'password' => ['required', 'string', Password::min(8)->letters()->mixedCase()->numbers()->symbols()],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $currentUser = Auth::user();
        $userIds = $request->user_ids;
        $resetCount = 0;

        foreach ($userIds as $userId) {
            $targetUser = User::find($userId);
            
            if (!$targetUser) {
                continue;
            }

            // Check permissions
            if ($currentUser->isSuperAdmin()) {
                // Super admin can reset any user's password
            } elseif ($currentUser->isSchoolAdmin()) {
                // School admin can only reset passwords for users in their school
                if ($targetUser->school_id !== $currentUser->school_id || $targetUser->isSuperAdmin()) {
                    continue; // Skip this user
                }
            } else {
                continue; // Skip if no permission
            }

            // Update password
            $targetUser->update([
                'password' => Hash::make($request->password)
            ]);

            $resetCount++;
        }

        return redirect()->back()->with('success', "Password reset for {$resetCount} user(s) successfully!");
    }

    /**
     * Show user profile with password change option
     */
    public function showProfile()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    /**
     * Get users for AJAX requests (for school admins)
     */
    public function getUsersForReset(Request $request)
    {
        $user = Auth::user();
        $query = $request->get('q', '');

        if ($user->isSuperAdmin()) {
            $users = User::where('name', 'like', "%{$query}%")
                ->orWhere('email', 'like', "%{$query}%")
                ->with('school')
                ->limit(20)
                ->get();
        } elseif ($user->isSchoolAdmin()) {
            $users = User::where('school_id', $user->school_id)
                ->where(function($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%")
                      ->orWhere('email', 'like', "%{$query}%");
                })
                ->where('role', '!=', 'super_admin') // School admin cannot see super admins
                ->with('school')
                ->limit(20)
                ->get();
        } else {
            return response()->json(['users' => []]);
        }

        return response()->json([
            'users' => $users->map(function($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->getRoleDisplayNameAttribute(),
                    'school' => $user->school ? $user->school->name : 'N/A',
                    'status' => $user->status
                ];
            })
        ]);
    }
}