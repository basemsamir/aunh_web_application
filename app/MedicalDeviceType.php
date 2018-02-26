<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Fish\Logger\Logger;
class MedicalDeviceType extends Model
{
    //
    use Logger;
    protected $fillable=['name','medical_device_category_id'];

    public function devices(){

  		return $this->hasMany('App\MedicalDevice');
  	}
    public function category()
    {
        return $this->belongsTo('App\MedicalDeviceCategory','medical_device_category_id');
    }
}
