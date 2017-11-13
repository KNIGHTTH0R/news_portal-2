<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';

    protected $fillable =[
        'name', 'access', 'slug'
    ];


    public function news()
    {
        return $this->hasMany('App\Models\News');
    }


}
