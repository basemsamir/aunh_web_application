<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MedicalDeviceCategory extends Model
{
    //
    protected $fillable=[
        'name',
        'arabic_name'  
    ];

    public function types()
    {
        return $this->hasMany('App\MedicalDeviceType');
    }
}
