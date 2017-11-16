<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tag';

    protected $fillable = ['name'];

    public function news()
    {
        return $this->belongsToMany('App\Models\News', 'news_tag', 'tag_id', 'news_id')
            ->withTimestamps();
    }



}
