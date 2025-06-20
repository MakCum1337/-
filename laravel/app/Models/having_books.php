<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class having_books extends Model
{
    protected $fillable=[
        'user_id',
        'books_id'
    ];
}
