<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Fish\Logger\Logger;
class Wsconfig extends Model
{
    //
    use Logger;
    protected $fillable=['url','sending_app','receiving_fac','sending_fac','receiving_app'];
}
