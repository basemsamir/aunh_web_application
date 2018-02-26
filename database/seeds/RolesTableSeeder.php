<?php

use Illuminate\Database\Seeder;
use App\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Role::truncate();
        Role::create([
            'name'=>'Registration',
            'arabic_name'=>'مسجل بيانات مرضى'
        ]);
        Role::create([
            'name'=>'Xray',
            'arabic_name'=>'مسجل أشعة'
        ]);
        Role::create([
            'name'=>'Lab',
            'arabic_name'=>'مسجل تحاليل'
        ]);
        
    }
}
