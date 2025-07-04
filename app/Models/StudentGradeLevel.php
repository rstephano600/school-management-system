<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentGradeLevel extends Model
{
    protected $fillable = ['student_id', 'grade_level_id', 'academic_year_id', 'start_date', 'end_date', 'is_current'];

    protected $casts = [
    'start_date' => 'date',
    'end_date' => 'date',
];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'user_id');
    }

    public function grade()
    {
        return $this->belongsTo(GradeLevel::class, 'grade_level_id');
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }
    public function changer()
{
    return $this->belongsTo(User::class, 'changed_by');
}

}
