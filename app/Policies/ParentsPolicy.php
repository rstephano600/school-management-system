<?php

namespace App\Policies;

use App\Models\Parents;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ParentsPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
                // Add your authorization logic here
        // Examples:
        
        // Option 1: Allow all authenticated users
        return true;
        
        // Option 2: Check user role
        // return $user->hasRole('admin') || $user->hasRole('teacher');
        
        // Option 3: Check specific permission
        // return $user->can('view-students');
        
        // Option 4: Check user type
        // return in_array($user->user_type, ['admin', 'teacher', 'staff']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Parents $parents): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Parents $parents): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Parents $parents): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Parents $parents): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Parents $parents): bool
    {
        return false;
    }
}
