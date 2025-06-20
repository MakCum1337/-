<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class books extends Model
{
    protected $fillable =[
        'title',
        'description',
        'author',
        'genre_id',
        'file',
        'price',
        'price_for_rent'
    ];
}
