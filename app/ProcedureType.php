<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProcedureType extends Model
{
    //


	public function procedures(){
		return $this->hasMany('App\Procedure');
	}
}
