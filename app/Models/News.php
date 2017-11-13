<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = 'news';

    protected $fillable =[
        'title', 'img_title', 'category_id', 'user_id', 'slug', 'body'
    ];

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }
}
