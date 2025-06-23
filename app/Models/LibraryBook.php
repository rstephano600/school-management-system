<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibraryBook extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'isbn',
        'title',
        'author',
        'publisher',
        'edition',
        'year_published',
        'category',
        'price',
        'quantity',
        'available_quantity',
        'rack_number',
        'status',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
