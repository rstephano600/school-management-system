<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'min_score',
        'max_score',
        'grade_letter',
        'grade_point',
        'remarks',
        'level',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'min_score' => 'integer',
        'max_score' => 'integer',
        'grade_point' => 'float',
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
