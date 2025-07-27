<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MichangoPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_reference',
        'student_michango_id',
        'amount',
        'payment_date',
        'payment_method',
        'payment_reference_number',
        'payment_description',
        'received_by',
        'verified_by',
        'verified_at'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'date',
        'verified_at' => 'datetime'
    ];

    // Relationships
    public function studentMichango()
    {
        return $this->belongsTo(StudentMichango::class);
    }

    public function receivedBy()
    {
        return $this->belongsTo(User::class, 'received_by');
    }

    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    // Boot method
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($payment) {
            if (empty($payment->payment_reference)) {
                $payment->payment_reference = 'MCH' . date('Y') . str_pad(MichangoPayment::count() + 1, 6, '0', STR_PAD_LEFT);
            }
        });
    }
}