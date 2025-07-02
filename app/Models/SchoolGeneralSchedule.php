<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolGeneralSchedule extends Model
{
protected $fillable = [
    'school_id', 'academic_year_id', 'day_of_week', 'activity',
    'start_time', 'end_time', 'description', 'status',
    'created_by', 'updated_by'
];


    public function school()
    {
        return $this->belongsTo(School::class);
    }
}

