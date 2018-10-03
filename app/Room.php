<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $guarded = [];
    //Many to many
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
