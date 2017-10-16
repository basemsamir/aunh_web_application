<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MedicalDevice extends Model
{
    //
	public function procedures(){
	
		return $this->belongsToMany('App\Procedure')->withPivot('id')->withTimestamps();
	}
	
	
}
