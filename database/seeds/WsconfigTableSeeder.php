<?php

use Illuminate\Database\Seeder;
use App\Wsconfig;
class WsconfigTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
		Wsconfig::create([
			'url' => 'http://172.16.0.118:2886/AUNHHL7?wsdl',
			'sending_app' => 'AUNHHIS',
			'sending_fac' => 'AUNH',
			'receiving_app' => '',
			'receiving_fac' => '',
		]);
    }
}
