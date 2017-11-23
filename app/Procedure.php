<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Fish\Logger\Logger;
class Procedure extends Model
{
    //
  use Logger;
  protected $fillable=['name','proc_ris_id','type_id'];
	public function proceduretype(){

		return $this->belongsTo('App\ProcedureType','type_id');
	}
	public function devices(){

		return $this->belongsToMany('App\MedicalDevice')->withPivot('id')->withTimestamps();;
	}
	public function medical_device_proc(){

		return $this->hasMany('App\MedicalDeviceProcedure');
	}
}
