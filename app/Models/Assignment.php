<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'class_id',
        'title',
        'description',
        'due_date',
        'max_points',
        'assignment_type',
        'file',
        'status',
        'created_by',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id'); // adjust if class model name is different
    }

    public function creator()
    {
        return $this->belongsTo(Teacher::class, 'created_by', 'user_id');
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }
}
