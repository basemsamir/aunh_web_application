<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Procedure extends Model
{
    //
	
	public function proceduretype(){
	
		return $this->belongsTo('App\ProcedureType');
	}
	public function devices(){
	
		return $this->belongsToMany('App\MedicalDevice')->withPivot('id')->withTimestamps();;
	}
}
