<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'student_id',
        'record_date',
        'height',
        'weight',
        'blood_group',
        'vision_left',
        'vision_right',
        'allergies',
        'medical_conditions',
        'immunizations',
        'last_checkup_date',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'allergies' => 'array',
        'medical_conditions' => 'array',
        'immunizations' => 'array',
        'record_date' => 'date',
        'last_checkup_date' => 'date',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'user_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
