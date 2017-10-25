<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    //
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

}
