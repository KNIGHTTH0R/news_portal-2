<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;


    protected $table = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role()
    {
        return $this->belongsToMany('App\Models\Role', 'user_role', 'user_id', 'role_id');
    }

    public function comment()
    {
        return $this->hasMany('App\Models\Comment');
    }

    public function news()
    {
        return $this->hasMany('App\Models\News');
    }

    public function rated_comment()
    {
        return $this->belongsToMany('App\Models\Comment', 'commentRate_user', 'user_id', 'comment_id')
                    ->withPivot('rate')
                    ->withTimestamps();
    }

    public function rated_down()
    {
        return $this->belongsToMany('App\Models\Comment', 'commentRate_user', 'user_id', 'comment_id')
            ->wherePivot('rate', 0)
            ->withTimestamps();
    }

    public function rated_up()
    {
        return $this->belongsToMany('App\Models\Comment', 'commentRate_user', 'user_id', 'comment_id')
            ->wherePivot('rate', 1)
            ->withTimestamps();
    }

    public function isAdmin()
    {
        if($this->role->isNotEmpty()) {
            if ($this->role->first()->id == 1) {
                return true;
            }
        } else {
            return false;
        }
    }
}
