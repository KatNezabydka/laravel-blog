<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //Get roles
    public function users()
    {
        return $this->belongsToMany('App\User');
    }
}