<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class having_physical_books extends Model
{
    protected $fillable=[
        'user_id',
        'physical_books_id'
    ];
}
