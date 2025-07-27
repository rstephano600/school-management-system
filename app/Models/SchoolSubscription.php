<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolSubscription extends Model
{
    protected $fillable = [
        'school_id',
        'subscription_category_id',
        'start_date',
        'end_date',
        'total_students',
        'is_active'
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function category()
    {
        return $this->belongsTo(SubscriptionCategory::class, 'subscription_category_id');
    }
}
