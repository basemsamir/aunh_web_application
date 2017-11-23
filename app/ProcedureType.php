<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Fish\Logger\Logger;
class ProcedureType extends Model
{
    //
	 use Logger;

	public function procedures(){
		return $this->hasMany('App\Procedure');
	}
}
