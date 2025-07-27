<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentPaymentRequirement extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'payment_category_id',
        'academic_year_id',
        'required_amount',
        'paid_amount',
        'balance',
        'status',
        'due_date',
        'is_mandatory',
        'notes',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'required_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'balance' => 'decimal:2',
        'due_date' => 'date',
        'is_mandatory' => 'boolean'
    ];

    // Relationships
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'user_id');
    }

    public function paymentCategory()
    {
        return $this->belongsTo(PaymentCategory::class);
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function payments()
    {
        return $this->hasMany(StudentPayment::class, 'student_id', 'student_id')
                    ->where('payment_category_id', $this->payment_category_id)
                    ->where('academic_year_id', $this->academic_year_id);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeOverdue($query)
    {
        return $query->where('status', 'overdue')
                     ->orWhere(function($q) {
                         $q->where('due_date', '<', now())
                           ->whereIn('status', ['pending', 'partial']);
                     });
    }

    // Methods
    public function updateBalance()
    {
        $this->balance = $this->required_amount - $this->paid_amount;
        $this->status = $this->balance <= 0 ? 'paid' : 
                       ($this->paid_amount > 0 ? 'partial' : 'pending');
        $this->save();
    }
}