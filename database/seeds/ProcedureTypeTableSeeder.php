<?php

use Illuminate\Database\Seeder;
use App\ProcedureType;
class ProcedureTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
		ProcedureType::create([
		    'name'=>'Radiology',
	    ]);
		ProcedureType::create([
		    'name'=>'Lab',
	    ]);
    }
}
