<?php

use Illuminate\Database\Seeder;
use App\MedicalDeviceCategory;

class MedicalDeviceCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        MedicalDeviceCategory::truncate();
        MedicalDeviceCategory::create([
            'name'=>'Xray',
            'arabic_name'=>'أشعة'
        ]);
        MedicalDeviceCategory::create([
            'name'=>'Lab',
            'arabic_name'=>'تحاليل'
        ]);
    }
}
