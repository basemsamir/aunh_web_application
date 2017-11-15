<?php

use Illuminate\Database\Seeder;
use App\MedicalDeviceType;
class MedicalDeviceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        MedicalDeviceType::create(['name'=>'CT']);
        MedicalDeviceType::create(['name'=>'CR']);
        MedicalDeviceType::create(['name'=>'DR']);
        MedicalDeviceType::create(['name'=>'DX']);
        MedicalDeviceType::create(['name'=>'MR']);
    }
}
