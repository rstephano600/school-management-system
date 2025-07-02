<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HolidayTimetable extends Model
{
    protected $table = 'holidays_timetable';

    protected $fillable = [
        'school_id',
        'academic_year_id',
        'name',
        'start_date',
        'end_date',
        'description',
        'status',
    ];

    public function school()        { return $this->belongsTo(School::class); }
    public function academicYear()  { return $this->belongsTo(AcademicYear::class); }
}

