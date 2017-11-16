<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Comment extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'comment';

    protected $fillable = [
        'body', 'user_id', 'news_id', 'parent_id'
    ];


    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function news()
    {
        return $this->belongsTo('App\Models\News');
    }

    public function child()
    {
        return $this->hasMany('App\Models\Comment', 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo('App\Models\Comment');
    }

    public function rated_user()
    {
        return $this->belongsToMany('App\Models\User', 'commentRate_user', 'comment_id', 'user_id')
            ->withPivot('rate')
            ->withTimestamps();
    }

    public function rated_down()
    {
        return $this->belongsToMany('App\Models\User', 'commentRate_user', 'comment_id', 'user_id')
            ->wherePivot('rate', 0);

    }

    public function rated_up()
    {
        return $this->belongsToMany('App\Models\User', 'commentRate_user', 'comment_id', 'user_id')
            ->wherePivot('rate', 1);

    }

}
