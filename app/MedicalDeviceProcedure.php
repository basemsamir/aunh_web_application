<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MedicalDeviceProcedure extends Model
{
    //
	protected $table='medical_device_procedure';

	public function order_item($value='')
	{
			return $this->hasMany('App\MedicalOrderItem');
	}

	public function device_order_item($value='')
	{
			return $this->belongsTo('App\MedicalDevice','medical_device_id');
	}
	public function proc_order_item($value='')
	{
			return $this->belongsTo('App\Procedure','procedure_id');
	}
}
