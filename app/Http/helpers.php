<?php
function calculateAge($birthdate){
	Carbon::setLocale('ar');
	$current_date = Carbon::today();
	$birthdate = Carbon::parse($birthdate);
	return $current_date->diffForHumans($birthdate,true);
}