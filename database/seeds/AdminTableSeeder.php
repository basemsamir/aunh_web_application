<?php

use Illuminate\Database\Seeder;
use App\AdminUser;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
		AdminUser::create([
			'name'=>'Admin',
			'email'=>'admin@aunh.com',
			'password'=>bcrypt("123456")
		]);
    }
}
