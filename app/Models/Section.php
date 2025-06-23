<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'user_id',
        'name',
        'code',
        'grade_id',
        'capacity',
        'room_id',
        'class_teacher_id',
        'academic_year_id',
        'status',
    ];

    public function school() { return $this->belongsTo(School::class); }
    public function user() { return $this->belongsTo(User::class); }
    public function grade() { return $this->belongsTo(GradeLevel::class, 'grade_id'); }
    public function room() { return $this->belongsTo(Room::class); }
    public function teacher() { return $this->belongsTo(Teacher::class, 'class_teacher_id', 'user_id'); }
    public function academicYear() { return $this->belongsTo(AcademicYear::class); }
}
