<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'title',
        'description',
        'category',
        'status',
        'city',
        'image',
        'user_id',
    ];
}
