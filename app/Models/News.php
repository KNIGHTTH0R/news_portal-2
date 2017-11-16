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

    public function comment()
    {
        return $this->hasMany('App\Models\Comment');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function tag()
    {
        return $this->belongsToMany('App\Models\Tag', 'news_tag', 'news_id', 'tag_id')
            ->withTimestamps();
    }
}
