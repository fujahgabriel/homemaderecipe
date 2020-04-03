<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerBox extends Model
{
    //
    protected $fillable = [
        'delivery_date', 'customer_name','recipe'
    ];

    protected $casts = [
        'recipe' => 'array'
    ];
}
