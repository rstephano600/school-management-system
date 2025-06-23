<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parents extends Model
{
    use HasFactory;

    // Since 'Parent' is a reserved keyword in PHP, we use a different table name
    protected $table = 'parents';

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
        'student_id',
        'occupation',
        'education',
        'annual_income',
        'relation_type',
        'company',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'annual_income' => 'decimal:2',
    ];

    /**
     * Get the user associated with the parent.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the school associated with the parent.
     */
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    /**
     * Get the student associated with the parent.
     */
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'user_id');
    }

    /**
     * Get the relation type in a readable format.
     */
    public function getFormattedRelationTypeAttribute()
    {
        return ucfirst($this->relation_type);
    }

    /**
     * Scope a query to filter by relation type.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRelationType($query, $type)
    {
        return $query->where('relation_type', $type);
    }

    /**
     * Get the formatted annual income with currency symbol.
     */
    public function getFormattedAnnualIncomeAttribute()
    {
        if ($this->annual_income) {
            return 'tz' . number_format($this->annual_income, 2);
        }
        return null;
    }
}