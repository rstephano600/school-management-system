<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class FeePayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'fee_structure_id', 'amount_paid', 'payment_date',
        'method', 'reference', 'note', 'received_by'
    ];

    protected $casts = [
        'payment_date' => 'date',
        'amount_paid' => 'decimal:2',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function fee()
    {
        return $this->belongsTo(FeeStructure::class, 'fee_structure_id');
    }
    public function receivedBy()
{
    return $this->belongsTo(User::class, 'received_by');
}

}

