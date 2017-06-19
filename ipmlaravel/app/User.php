<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'user';
    protected $primaryKey  = 'user_id';
   
    protected $fillable = [
        'profile_name', 'username', 'password','role','status','profile_pic','project_id'
    ];

    protected $hidden = [
        'password',
    ];
}
