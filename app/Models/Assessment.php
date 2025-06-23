<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'academic_year_id',
        'grade_id',
        'class_id',
        'subject_id',
        'teacher_id',
        'type',
        'title',
        'description',
        'issue_date',
        'due_date',
        'is_published',
    ];

    public function school() {
        return $this->belongsTo(School::class);
    }

    public function academicYear() {
        return $this->belongsTo(AcademicYear::class);
    }

    public function grade() {
        return $this->belongsTo(GradeLevel::class);
    }

    public function classModel() {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    public function subject() {
        return $this->belongsTo(Subject::class);
    }

    public function teacher() {
        return $this->belongsTo(Teacher::class);
    }
}
