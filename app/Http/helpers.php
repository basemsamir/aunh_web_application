<?php
use Carbon\Carbon;
function calculateAge($birthdate){
    if($birthdate != "0000-00-00")
	{
        Carbon::setLocale('ar');
	    $current_date = Carbon::today();
	    $birthdate = Carbon::parse($birthdate);
        return $current_date->diffForHumans($birthdate,true);
    }
    return '';
}