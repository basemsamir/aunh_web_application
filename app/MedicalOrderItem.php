<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MedicalOrderItem extends Model
{
    //
	protected $fillable=[
		'visit_id',
		'medical_device_procedure_id',
		'user_id',
	
	];
	public function visit(){
		return $this->belongsTo('App\Visit');
	}
}
