<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentMichango extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'michango_category_id',
        'pledged_amount',
        'paid_amount',
        'balance',
        'status',
        'pledge_date',
        'notes',
        'recorded_by',
        'updated_by'
    ];

    protected $casts = [
        'pledged_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'balance' => 'decimal:2',
        'pledge_date' => 'date'
    ];

    // Relationships
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'user_id');
    }

    public function michangoCategory()
    {
        return $this->belongsTo(MichangoCategory::class);
    }

    public function payments()
    {
        return $this->hasMany(MichangoPayment::class);
    }

    public function recordedBy()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    // Methods
    public function updateBalance()
    {
        $this->balance = $this->pledged_amount - $this->paid_amount;
        $this->status = $this->balance <= 0 ? 'completed' : 
                       ($this->paid_amount > 0 ? 'partial' : 'pledged');
        $this->save();
    }
}
