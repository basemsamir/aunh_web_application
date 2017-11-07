<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    //
    protected $fillable=['name'];
    public function medical_order_item($value='')
    {
      # code...
        return $this->hasMany('App\MedicalOrderItem');
    }
}
