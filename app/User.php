<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

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

    //Get roles
    public function roles(){
        return $this->belongsToMany('App\Role');
    }

    //Get userAdditional
    public function user_additional(){
        return $this->hasOne('App\UserAdditional');
    }

    //One to many
    public function articles(){
        return $this->hasMany('App\Article');
    }

    // Users и Comment - многие к одному - один юзер может написать много коммент, получаем комменты, которые привязанны к конкретному пользователю
    public function comment()
    {
        return $this->hasMany('App\Comment');
    }
    //Получить статьи на которые подписаны (через автора) subscribe
    public function article_subscribe(){
        return $this->belongsToMany('App\User');
    }
}

