<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolEvent extends Model
{
    protected $table = 'school_events';

    protected $fillable = [
        'school_id',
        'academic_year_id',
        'title',
        'description',
        'event_date',
        'start_time',
        'end_time',
        'location',
        'status',
    ];

    public function school()        { return $this->belongsTo(School::class); }
    public function academicYear()  { return $this->belongsTo(AcademicYear::class); }
}

