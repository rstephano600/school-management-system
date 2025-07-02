<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademicRecord extends Model
{
    protected $fillable = [
        'school_id',
        'student_id',
        'academic_year_id',
        'semester_id',
        'class_id',
        'subject_id',
        'average_exam_score',
        'average_assignment_score',
        'final_score',
        'final_grade',
        'remarks',
    ];

    public function student() {
        return $this->belongsTo(Student::class, 'student_id', 'user_id');
    }

    public function year() {
        return $this->belongsTo(AcademicYear::class, 'academic_year_id');
    }

    public function semester() {
        return $this->belongsTo(Semester::class);
    }

    public function class() {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function subject() {
        return $this->belongsTo(Subject::class);
    }
}

