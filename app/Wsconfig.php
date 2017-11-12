<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wsconfig extends Model
{
    //
    protected $fillable=['url','sending_app','receiving_fac','sending_fac','receiving_app'];
}
