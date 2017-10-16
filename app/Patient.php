<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    //
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
