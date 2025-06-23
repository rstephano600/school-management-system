<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HostelRoom extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'hostel_id',
        'room_number',
        'room_type',
        'capacity',
        'current_occupancy',
        'cost_per_bed',
        'status',
    ];

    public function hostel()
    {
        return $this->belongsTo(Hostel::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function getIsFullAttribute()
    {
        return $this->current_occupancy >= $this->capacity;
    }
}
