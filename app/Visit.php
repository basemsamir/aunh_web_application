<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Fish\Logger\Logger;
class Visit extends Model
{
    //
	use Logger;
	protected $fillable=[
		'patient_id',
		'entry_id',
		'user_id',

	];
	public function patient(){
		return $this->belongsTo('App\Patient');
	}

	public function orders(){
		return $this->hasMany('App\MedicalOrderItem');
	}
	public function user(){
		return $this->belongsTo('App\User');
	}
}
