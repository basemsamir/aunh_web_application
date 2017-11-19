<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;

class SINValidationRuleProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Validator::extend('sin_format', function($attribute, $value, $parameters, $validator) {
           return $this->check_sin_format($value);
        });
    }

    public function check_sin_format($value='')
    {
      # code...
        if(strlen($value) != 14)
          return false;
        $birthdate="";
        if($value[0] == "1" || $value[0] == "2" || $value[0] == "3")
        {
            switch($value[0]){
                case '1':
                  $birthdate.='18';
                  break;
                case '2':
                  $birthdate.='19';
                  break;
                case '3':
                  $birthdate.='20';
                  break;
            }
            $birthdate.=substr($value,1,6);
            $validator = Validator::make(['birthdate'=>$birthdate], [
                'birthdate' => 'date',
            ]);
            if ($validator->fails()) {
                return false;
            }
            return true;
        }
        return false;
    }
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

}
