<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'title',
        'content',
        'start_date',
        'end_date',
        'audience',
        'status',
        'created_by',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
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
        if ($value === 'archived') {
            return 'archived';
        }

        return now()->gt($this->end_date) ? 'archived' : $value;
    }
}
