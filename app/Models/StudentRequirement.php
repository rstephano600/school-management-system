<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentRequirement extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id', 'name', 'quantity', 'description', 'allow_payment', 'expected_amount', 
        'grade_level_id', 'created_by', 'updated_by'
    ];

    public function school() { return $this->belongsTo(School::class); }

    public function gradeLevel() { return $this->belongsTo(GradeLevel::class); }

    public function submissions() { return $this->hasMany(StudentRequirementSubmission::class); }
}

