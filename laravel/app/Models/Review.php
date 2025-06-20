<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'user_id',
        'physical_book_id',
        'book_id',
        'review',
        'rating'
    ];
}
