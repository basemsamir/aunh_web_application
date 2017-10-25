<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MedicalOrderItem extends Model
{
    //
	protected $fillable=[
		'visit_id',
		'medical_device_procedure_id',
		'procedure_status',
		'procedure_date',
		'user_id',
		'department_id',
		'xray_doctor_id'

	];
	public function visit(){
		return $this->belongsTo('App\Visit');
	}
	public function department(){
		return $this->belongsTo('App\Department');
	}
	public function ref_doctor(){
		return $this->belongsTo('App\Doctor','xray_doctor_id');
	}
}
