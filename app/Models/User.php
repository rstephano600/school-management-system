<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
        'school_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    public function school()
    {
    return $this->belongsTo(School::class);
    }

    public function parentProfile()
{
    return $this->hasOne(Parents::class, 'user_id');

}

public function teacher()
{
    return $this->hasOne(Teacher::class, 'user_id');
}


public function subjects()
{
    return $this->belongsToMany(Subject::class, 'subject_teacher', 'teacher_id', 'subject_id');
}
    /**
     * Check if user is active
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Check if user is pending approval
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if user is suspended
     */
    public function isSuspended(): bool
    {
        return $this->status === 'suspended';
    }

    /**
     * Activate user account
     */
    public function activate(): void
    {
        $this->update(['status' => 'active']);
    }

    /**
     * Suspend user account
     */
    public function suspend(): void
    {
        $this->update(['status' => 'suspended']);
    }

    /**
     * Block user account
     */
    public function block(): void
    {
        $this->update(['status' => 'blocked']);
    }
}

