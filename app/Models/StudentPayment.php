<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_reference',
        'student_id',
        'payment_category_id',
        'academic_year_id',
        'amount',
        'payment_date',
        'payment_method',
        'payment_reference_number',
        'payment_notes',
        'status',
        'received_by',
        'verified_by',
        'verified_at',
        'verification_notes'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'date',
        'verified_at' => 'datetime'
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

    public function receivedBy()
    {
        return $this->belongsTo(User::class, 'received_by');
    }

    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    // Boot method to generate payment reference
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($payment) {
            if (empty($payment->payment_reference)) {
                $payment->payment_reference = 'PAY' . date('Y') . str_pad(StudentPayment::count() + 1, 6, '0', STR_PAD_LEFT);
            }
        });
    }
}