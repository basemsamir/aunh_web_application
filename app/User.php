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
        'name', 'email', 'password','role_id'
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

    public function setPasswordAttribute($value){
        $this->attributes['password'] = bcrypt($value);
    }
    public function visits(){
        return $this->hasMany('App\Visit');
    }
    
    public function role()
    {
        return $this->belongsTo('App\Role');
    }
}
