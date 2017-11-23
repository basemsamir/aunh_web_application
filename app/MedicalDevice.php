<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Fish\Logger\Logger;
class MedicalDevice extends Model
{
    //
	use Logger;
	protected $fillable=['name','medical_device_type_id','location'];
	public function procedures(){

		return $this->belongsToMany('App\Procedure')->withPivot('id')->withTimestamps();
	}
	public function medical_device_proc(){

		return $this->hasMany('App\MedicalDeviceProcedure');
	}
	public function medical_device_type(){

		return $this->belongsTo('App\MedicalDeviceType');
	}
}
