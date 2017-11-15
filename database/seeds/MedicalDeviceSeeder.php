<?php

use Illuminate\Database\Seeder;
use App\MedicalDevice;

class MedicalDeviceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

    		MedicalDevice::truncate();
    		MedicalDevice::create([
    			'name'=>'CT Machine',
          'medical_device_type_id'=>1,
    			'location'=>'Clinics'
    		]);
    		MedicalDevice::create([
    			'name'=>'MR Machine',
          'medical_device_type_id'=>5,
    			'location'=>'Clinics'
    		]);
    		MedicalDevice::create([
    			'name'=>'X-Ray Machine (أ)',
          'medical_device_type_id'=>2,
    			'location'=>'Clinics'
    		]);
    		MedicalDevice::create([
    			'name'=>'X-Ray Machine  ( م )',
          'medical_device_type_id'=>2,
    			'location'=>'Clinics'
    		]);
    		MedicalDevice::create([
    			'name'=>'X-Ray Machine  ( ل )',
          'medical_device_type_id'=>2,
    			'location'=>'Clinics'
    		]);
    		MedicalDevice::create([
    			'name'=>'X-Ray Machine  ( هـ )',
          'medical_device_type_id'=>2,
    			'location'=>'Clinics'
    		]);
    		MedicalDevice::create([
    			'name'=>'X-Ray Machine  ( د )',
          'medical_device_type_id'=>2,
    			'location'=>'Clinics'
    		]);
    		MedicalDevice::create([
    			'name'=>'X-Ray Machine  ( ب )',
          'medical_device_type_id'=>2,
    			'location'=>'Clinics'
    		]);
    		MedicalDevice::create([
    			'name'=>'E أشعة رنين مغناطيسى-إصابات ',
          'medical_device_type_id'=>5,
    			'location'=>'Clinics'
    		]);
    		MedicalDevice::create([
    			'name'=>'Emerg-CT',
          'medical_device_type_id'=>1,
    			'location'=>'Clinics'
    		]);
    		MedicalDevice::create([
    			'name'=>'DR رجالى',
          'medical_device_type_id'=>4,
    			'location'=>'Clinics'
    		]);
    		MedicalDevice::create([
    			'name'=>'DR حريمى',
            'medical_device_type_id'=>4,
    			'location'=>'Clinics'
    		]);
    		MedicalDevice::create([
    			'name'=>'E أشعة عادية-إصابات DR',
            'medical_device_type_id'=>4,
    			'location'=>'Clinics'
    		]);
    		MedicalDevice::create([
    			'name'=>'Ortho Machine',
            'medical_device_type_id'=>2,
    			'location'=>'Clinics'
    		]);
    		MedicalDevice::create([
    			'name'=>'CT-64 Machine',
            'medical_device_type_id'=>1,
    			'location'=>'Clinics'
    		]);
    		MedicalDevice::create([
    			'name'=>'E داخلى إصابات',
            'medical_device_type_id'=>2,
    			'location'=>'Clinics'
    		]);
    		MedicalDevice::create([
    			'name'=>'Ortho OT',
            'medical_device_type_id'=>2,
    			'location'=>'Clinics'
    		]);
    }
}
