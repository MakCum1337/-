<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class physical_books extends Model
{
    protected $fillable =[
        'title',
        'description',
        'author',
        'genre_id',
        'count',
        'price',
        'price_for_rent'
    ];
}
