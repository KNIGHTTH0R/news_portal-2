<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';

    protected $fillable =[
        'name', 'protected', 'slug'
    ];


    public function news()
    {
        return $this->hasMany('App\Models\News');
    }

    public function news_nav()
    {
        return $this->hasMany('App\Models\News');
    }


}
