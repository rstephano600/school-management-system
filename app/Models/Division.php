<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'min_point',
        'max_point',
        'division',
        'remarks',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'min_point' => 'float',
        'max_point' => 'float',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
