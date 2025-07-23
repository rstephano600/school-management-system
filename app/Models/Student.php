<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $primaryKey = 'user_id';
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'admitted_by',
        'school_id',
        'admission_number',
        'fname',
        'mname',
        'lname',
        'admission_date',
        'grade_id',
        'section_id',
        'roll_number',
        'date_of_birth',
        'gender',
        'blood_group',
        'religion',
        'nationality',
        'is_transport',
        'is_hostel',
        'status',
        'previous_school_info',
    ];

    protected $casts = [
        'admission_date' => 'date',
        'date_of_birth' => 'date',
        'is_transport' => 'boolean',
        'is_hostel' => 'boolean',
        'previous_school_info' => 'array',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function admittedBy()
    {
        return $this->belongsTo(User::class, 'admitted_by');
    }

    public function school()
    {
        return $this->belongsTo(School::class, 'school_id');
    }

    public function grade()
    {
        return $this->belongsTo(GradeLevel::class, 'grade_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeGraduated($query)
    {
        return $query->where('status', 'graduated');
    }

    public function scopeTransferred($query)
    {
        return $query->where('status', 'transferred');
    }

    public function parents()
{
    return $this->hasMany(Parents::class, 'student_id', 'user_id');
}

public function guardians()
{
    return $this->parents()->where('relation_type', 'guardian');
}

public function mother()
{
    return $this->parents()->where('relation_type', 'mother')->first();
}

public function father()
{
    return $this->parents()->where('relation_type', 'father')->first();
}
public function currentClass()
{
    return $this->belongsTo(GradeLevel::class, 'current_class_id');
}

}
