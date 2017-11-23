<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Fish\Logger\Logger;
class Patient extends Model
{
    //
	use Logger;
	protected $fillable=[
		'name',
		'birthdate',
		'gender',
		'address',
		'nationality',
		'sin',
		'phone_num'

	];
	public function visits(){
		return $this->hasMany('App\Visit');
	}
}
