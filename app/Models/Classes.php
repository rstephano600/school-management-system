<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    use HasFactory;

    protected $table = 'classes';

    protected $fillable = [
        'school_id',
        'academic_year_id',
        'subject_id',
        'grade_id',
        'section_id',
        'teacher_id',
        'room_id',
        'class_days',
        'start_time',
        'end_time',
        'max_capacity',
        'current_enrollment',
        'status',
    ];

    protected $casts = [
        'class_days' => 'array',
    ];

    public function subject()      { return $this->belongsTo(Subject::class, 'subject_id'); }
    public function grade()        { return $this->belongsTo(GradeLevel::class, 'grade_id'); }
    public function section()      { return $this->belongsTo(Section::class, 'section_id'); }
    public function teacher()      { return $this->belongsTo(User::class, 'teacher_id'); }
    public function room()         { return $this->belongsTo(Room::class, 'room_id'); }
    public function academicYear() { return $this->belongsTo(AcademicYear::class); }
}
