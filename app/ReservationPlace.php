<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReservationPlace extends Model
{
    //
	
	public function users(){
		return $this->belongsToMany('App\User')->withTimestamps();
	}
}
