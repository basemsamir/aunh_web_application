<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Fish\Logger\Logger;
class ReservationPlace extends Model
{
    //
	use Logger;
	protected $fillable=['name'];
	public function users(){
		return $this->belongsToMany('App\User')->withTimestamps();
	}
}
