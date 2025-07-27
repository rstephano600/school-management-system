<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MichangoCategory extends Model
{


    protected $fillable = [
        'school_id',
        'name',
        'code',
        'description',
        'target_amount',
        'collected_amount',
        'start_date',
        'end_date',
        'is_active',
        'applicable_grades',
        'contribution_type',
        'suggested_amount',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'target_amount' => 'decimal:2',
        'collected_amount' => 'decimal:2',
        'suggested_amount' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
        'applicable_grades' => 'array'
    ];

    // Relationships
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function studentMichango()
    {
        return $this->hasMany(StudentMichango::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Methods
    public function getProgressPercentageAttribute()
    {
        if ($this->target_amount <= 0) return 0;
        return min(100, ($this->collected_amount / $this->target_amount) * 100);
    }
}
