<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'submission_id',
        'student_id',
        'class_id',
        'grade_value',
        'score',
        'max_score',
        'comments',
        'graded_by',
        'grade_date',
    ];

    // Relationships
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'user_id');
    }

    public function class()
    {
        return $this->belongsTo(Classes::class);
    }

    public function grader()
    {
        return $this->belongsTo(Teacher::class, 'graded_by', 'user_id');
    }
}
