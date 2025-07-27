<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'school_id',
        'name',
        'code',
        'type',
        'category',
        'description',
        'is_active',
        'applicable_grades',
        'payment_frequency',
        'required_at_registration',
        'required_at_grade_entry',
        'default_amount',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'applicable_grades' => 'array',
        'is_active' => 'boolean',
        'required_at_registration' => 'boolean',
        'required_at_grade_entry' => 'boolean',
        'default_amount' => 'decimal:2'
    ];

    // Relationships
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function gradeLevelFees()
    {
        return $this->hasMany(GradeLevelFee::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeForGrade($query, $gradeId)
    {
        return $query->whereJsonContains('applicable_grades', $gradeId)
                     ->orWhereNull('applicable_grades');
    }

    public function scopeRequiredAtRegistration($query)
    {
        return $query->where('required_at_registration', true);
    }
}