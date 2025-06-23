<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'name',
        'code',
        'address',
        'city',
        'state',
        'country',
        'postal_code',
        'phone',
        'email',
        'website',
        'logo',
        'established_date',
        'status',
    ];

    protected $casts = [
        'established_date' => 'date',
        'status' => 'boolean',
    ];

    public function users()
{
    return $this->hasMany(User::class);
}

public function library()
{
    return $this->hasOne(Library::class);
}

public function health()
{
    return $this->hasOne(Health::class);
}

public function activities()
{
    return $this->hasMany(Activity::class);
}

public function parents()
{
    return $this->hasMany(Parents::class);
}

}

