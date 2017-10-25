<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    //
    public function medical_order_item($value='')
    {
      # code...
        return $this->hasMany('App\MedicalOrderItem');
    }
}
