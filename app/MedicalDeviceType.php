<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MedicalDeviceType extends Model
{
    //
    protected $fillable=['name'];

    public function devices(){

  		return $this->hasMany('App\MedicalDevice');
  	}
}
