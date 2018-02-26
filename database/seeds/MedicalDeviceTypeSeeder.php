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
        MedicalDeviceType::truncate();
        MedicalDeviceType::create(['name'=>'CT','medical_device_category_id'=>1]);
        MedicalDeviceType::create(['name'=>'CR','medical_device_category_id'=>1]);
        MedicalDeviceType::create(['name'=>'DR','medical_device_category_id'=>1]);
        MedicalDeviceType::create(['name'=>'DX','medical_device_category_id'=>1]);
        MedicalDeviceType::create(['name'=>'MR','medical_device_category_id'=>1]);
        MedicalDeviceType::create(['name'=>'Lab12','medical_device_category_id'=>2]);
    }
}
