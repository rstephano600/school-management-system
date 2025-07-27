<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentRequirementSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'student_requirement_id', 'fulfilled_by', 'quantity_received', 'quantity_remain', 
        'amount_paid', 'is_verified', 'notes', 'created_by', 'updated_by'
    ];

    public function student()
{
    return $this->belongsTo(Student::class, 'student_id');
}


    public function requirement() { return $this->belongsTo(StudentRequirement::class, 'student_requirement_id'); }
}

