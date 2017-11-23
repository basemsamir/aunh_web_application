<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Fish\Logger\Logger;

class AdminUser extends Authenticatable
{
    use Logger;
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

	protected $guard = "admin";
}
