<?php

use Illuminate\Database\Seeder;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
		User::truncate();
		
		User::create([
			'name'=>'Xray',
			'email'=>'xray@aunh.com',
			'password'=>bcrypt("123456")
		]);
    }
}
