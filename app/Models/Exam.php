<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'exam_type_id',
        'title',
        'description',
        'start_date',
        'end_date',
        'academic_year_id',
        'grade_id',
        'subject_id',
        'total_marks',
        'passing_marks',
        'status',
        'created_by',
    ];

    // Relationships
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function examType()
    {
        return $this->belongsTo(ExamType::class);
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function grade()
    {
        return $this->belongsTo(GradeLevel::class, 'grade_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function creator()
    {
        return $this->belongsTo(Teacher::class, 'created_by', 'user_id');
    }
}
