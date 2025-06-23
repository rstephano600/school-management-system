<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'user_id';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'school_id',
        'employee_id',
        'joining_date',
        'designation',
        'department',
        'qualification',
        'experience',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'joining_date' => 'date',
        'status' => 'boolean',
    ];

    /**
     * Get the user associated with the staff member.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the school associated with the staff member.
     */
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    /**
     * Scope a query to only include active staff.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

}