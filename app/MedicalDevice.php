<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MedicalDevice extends Model
{
    //
	protected $fillable=['name','location'];
	public function procedures(){

		return $this->belongsToMany('App\Procedure')->withPivot('id')->withTimestamps();
	}
	public function medical_device_proc(){

		return $this->hasMany('App\MedicalDeviceProcedure');
	}

}
