<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HostelAllocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'student_id',
        'hostel_id',
        'room_id',
        'bed_number',
        'allocation_date',
        'deallocation_date',
        'status',
    ];

    protected $casts = [
        'allocation_date' => 'date',
        'deallocation_date' => 'date',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'user_id');
    }

    public function hostel()
    {
        return $this->belongsTo(Hostel::class);
    }

    public function room()
    {
        return $this->belongsTo(HostelRoom::class, 'room_id');
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
