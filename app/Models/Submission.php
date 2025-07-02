<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'assignment_id',
        'student_id',
        'submission_date',
        'file',
        'notes',
        'status',
        'graded_by',
    ];

    // Relationships
    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'user_id');
    }

    public function grader()
    {
        return $this->belongsTo(Teacher::class, 'graded_by', 'user_id');
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}

