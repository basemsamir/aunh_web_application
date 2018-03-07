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

	public function setPhoneNumAttribute($value){
		$this->attributes['phone_num']=($value == "")?null:$value;
	}
	public function getPhoneNumAttribute($value){
		return $value == 0?'':$value;
	}
	public function visits(){
		return $this->hasMany('App\Visit');
	}
}
