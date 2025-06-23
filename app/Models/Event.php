<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'title',
        'description',
        'start_datetime',
        'end_datetime',
        'location',
        'event_type',
        'audience',
        'status',
        'created_by',
    ];

    protected $casts = [
        'start_datetime' => 'datetime',
        'end_datetime' => 'datetime',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function getStatusAttribute($value)
    {
        if ($value === 'cancelled') {
            return 'cancelled';
        }

        return now()->greaterThan($this->end_datetime) ? 'completed' : 'scheduled';
    }
}

