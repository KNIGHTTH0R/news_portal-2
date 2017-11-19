<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    protected $table = 'advertisement';

    protected $fillable = [
        'text',
        'sale_text',
        'sale_title',
        'seller',
        'price',
        'sale_price',
        'block_side',
        'block_position'
    ];
}
