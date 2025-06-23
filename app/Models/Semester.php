<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    use HasFactory;

protected $fillable = [
    'academic_year_id',
    'school_id',
    'name',
    'start_date',
    'end_date',
    'is_current',
];


    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_current' => 'boolean',
    ];
    public function school()
{
    return $this->belongsTo(School::class);
}


    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }
}
