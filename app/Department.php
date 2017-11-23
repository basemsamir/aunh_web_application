<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Fish\Logger\Logger;
class Department extends Model
{
    use Logger;
    //
    protected $fillable=['name'];
    public function medical_order_item($value='')
    {
      # code...
        return $this->hasMany('App\MedicalOrderItem');
    }
}
