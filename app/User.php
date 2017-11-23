<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Fish\Logger\Logger;
class User extends Authenticatable
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

	public function reservation_places(){
		return $this->belongsToMany('App\ReservationPlace')->withTimestamps();
	}

  public function visits()
  {
    return $this->hasMany('App\Visit');
  }
}
