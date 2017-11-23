<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Fish\Logger\Logger;
class MedicalDeviceType extends Model
{
    //
    use Logger;
    protected $fillable=['name'];

    public function devices(){

  		return $this->hasMany('App\MedicalDevice');
  	}
}
