<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscribe extends Model
{
    protected $table = 'subscribe';

    protected $fillable = [
        'name', 'email', 'status'
    ];
}
