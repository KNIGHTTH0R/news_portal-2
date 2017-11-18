<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActiveClient extends Model
{
    protected $table = 'active_client';

    protected $fillable = ['ip', 'user_agent', 'token', 'last_seen_at', 'news_id'];

    public $timestamps = false;

    public function news()
    {
        return $this->belongsTo('App\Models\News');
    }
}
