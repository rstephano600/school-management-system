<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hostel extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'name',
        'type',
        'address',
        'contact_number',
        'warden_id',
        'capacity',
        'description',
        'status',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function warden()
    {
        return $this->belongsTo(Staff::class, 'warden_id', 'user_id');
    }
}
