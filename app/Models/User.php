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

    /**
     * Define the available user roles
     */
    public static function getRoles(): array
    {
        return [
            'super_admin' => 'Super Administrator',
            'school_admin' => 'School Administrator',
            'school_creator' => 'School Creator',
            'director' => 'Director',
            'manager' => 'Manager',
            'head_master' => 'Head Master',
            'secretary' => 'Secretary',
            'academic_master' => 'Academic Master',
            'teacher' => 'Teacher',
            'staff' => 'Staff',
            'school_doctor' => 'School Doctor',
            'school_librarian' => 'School Librarian',
            'parent' => 'Parent',
            'student' => 'Student'
        ];
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function student()
    {
        return $this->hasOne(Student::class, 'user_id');
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

    /**
     * Check if user is a teacher
     */
    public function isTeacher(): bool
    {
        return $this->teacher()->exists();
    }

    /**
     * Check if user is a student
     */
    public function isStudent(): bool
    {
        return $this->student()->exists();
    }

    /**
     * Check if user is a parent
     */
    public function isParent(): bool
    {
        return $this->parentProfile()->exists();
    }

    /**
     * Check if user is a super admin
     */
    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    /**
     * Check if user is a school admin
     */
    public function isSchoolAdmin(): bool
    {
        return $this->role === 'school_admin';
    }

    /**
     * Check if user is a school creator
     */
    public function isSchoolCreator(): bool
    {
        return $this->role === 'school_creator';
    }

    /**
     * Check if user has administrative privileges
     */
    public function hasAdminPrivileges(): bool
    {
        return in_array($this->role, ['super_admin', 'school_admin', 'school_creator']);
    }

    /**
     * Check if user can manage schools
     */
    public function canManageSchools(): bool
    {
        return in_array($this->role, ['super_admin', 'school_creator']);
    }

    /**
     * Get schools that user can manage
     */
    public function manageableSchools()
    {
        if ($this->isSuperAdmin()) {
            return School::query();
        } elseif ($this->isSchoolCreator()) {
            return School::where('modified_by', $this->id);
        }
        
        return School::whereRaw('1 = 0'); // Return empty query
    }

    public function createdAssessments()
    {
        return $this->hasMany(Assessment::class, 'created_by');
    }

    public function updatedAssessments()
    {
        return $this->hasMany(Assessment::class, 'updated_by');
    }

    /**
     * Get assessment results recorded by this user.
     */
    public function recordedResults()
    {
        return $this->hasMany(AssessmentResult::class, 'recorded_by');
    }

    /**
     * Get schools created by this user (for school_creator role)
     */
    public function createdSchools()
    {
        return $this->hasMany(School::class, 'modified_by');
    }

    public function getFullNameAttribute(): string
    {
        if ($this->isStudent() && $this->student) {
            return trim($this->student->fname . ' ' . $this->student->mname . ' ' . $this->student->lname);
        }
        
        return $this->name;
    }

    /**
     * Get user's role display name
     */
    public function getRoleDisplayNameAttribute(): string
    {
        $roles = self::getRoles();
        return $roles[$this->role] ?? ucfirst(str_replace('_', ' ', $this->role));
    }

    /**
     * Scope to filter users by role
     */
    public function scopeByRole($query, $role)
    {
        return $query->where('role', $role);
    }

    /**
     * Scope to filter active users
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope to filter users by school
     */
    public function scopeBySchool($query, $schoolId)
    {
        return $query->where('school_id', $schoolId);
    }
}