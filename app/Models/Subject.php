<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    // Explicit table name
    protected $table = 'subject';

    protected $fillable = [
        'school_id',
        'user_id',
        'name',
        'code',
        'description',
        'is_core',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

public function teachers()
{
    return $this->belongsToMany(User::class, 'subject_teacher', 'subject_id', 'teacher_id');
}

}
