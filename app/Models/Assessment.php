<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id', 'title', 'type', 'grade_level_id',
        'subject_id', 'academic_year_id', 'semester_id',
        'due_date', 'description'
    ];
    protected $casts = [
    'due_date' => 'date',
];
    public function school()         { return $this->belongsTo(School::class); }
    public function gradeLevel()     { return $this->belongsTo(GradeLevel::class); }
    public function subject()        { return $this->belongsTo(Subject::class); }
    public function academicYear()   { return $this->belongsTo(AcademicYear::class); }
    public function semester()       { return $this->belongsTo(Semester::class); }
}

