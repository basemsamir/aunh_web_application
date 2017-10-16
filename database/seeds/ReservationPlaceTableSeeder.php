<?php

use Illuminate\Database\Seeder;
use App\ReservationPlace;
use App\User;
class ReservationPlaceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
		ReservationPlace::truncate();
	    $r=ReservationPlace::create([
			  'name'=>'xray 1',
			  'location'=>'xray_office'
		  ]);
		
		$user=User::find(1);
		$r->users()->attach($user);
		
    }
}
