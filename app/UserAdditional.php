<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAdditional extends Model
{
    protected $fillable = [
        'firstname', 'lastname', 'patronymic',
    ];
    //Get user
    public function user(){
        return $this->belongsTo('App\User');
    }
}
