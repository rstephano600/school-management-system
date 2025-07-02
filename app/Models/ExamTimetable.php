<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamTimetable extends Model
{
    protected $table = 'exams_timetable';

    protected $fillable = [
        'school_id',
        'academic_year_id',
        'class_id',
        'subject_id',
        'teacher_id',
        'test_date',
        'start_time',
        'end_time',
        'title',
        'description',
        'status',
    ];

    public function school()        { return $this->belongsTo(School::class); }
    public function academicYear()  { return $this->belongsTo(AcademicYear::class); }
    public function class()         { return $this->belongsTo(Classes::class); }
    public function subject()       { return $this->belongsTo(Subject::class); }
    public function teacher()       { return $this->belongsTo(Teacher::class, 'teacher_id', 'user_id'); }
}

