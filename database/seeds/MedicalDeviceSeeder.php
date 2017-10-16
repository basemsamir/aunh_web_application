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
			'location'=>'Clinics'
		]);
		MedicalDevice::create([
			'name'=>'MR Machine',
			'location'=>'Clinics'
		]);
		MedicalDevice::create([
			'name'=>'X-Ray Machine (أ)',
			'location'=>'Clinics'
		]);
		MedicalDevice::create([
			'name'=>'X-Ray Machine  ( م )',
			'location'=>'Clinics'
		]);
		MedicalDevice::create([
			'name'=>'X-Ray Machine  ( ل )',
			'location'=>'Clinics'
		]);
		MedicalDevice::create([
			'name'=>'X-Ray Machine  ( هـ )',
			'location'=>'Clinics'
		]);
		MedicalDevice::create([
			'name'=>'X-Ray Machine  ( د )',
			'location'=>'Clinics'
		]);
		MedicalDevice::create([
			'name'=>'X-Ray Machine  ( ب )',
			'location'=>'Clinics'
		]);
		MedicalDevice::create([
			'name'=>'E أشعة رنين مغناطيسى-إصابات ',
			'location'=>'Clinics'
		]);
		MedicalDevice::create([
			'name'=>'Emerg-CT',
			'location'=>'Clinics'
		]);
		MedicalDevice::create([
			'name'=>'DR رجالى',
			'location'=>'Clinics'
		]);
		MedicalDevice::create([
			'name'=>'DR حريمى',
			'location'=>'Clinics'
		]);
		MedicalDevice::create([
			'name'=>'E أشعة عادية-إصابات DR',
			'location'=>'Clinics'
		]);
		MedicalDevice::create([
			'name'=>'Ortho Machine',
			'location'=>'Clinics'
		]);
		MedicalDevice::create([
			'name'=>'CT-64 Machine',
			'location'=>'Clinics'
		]);
		MedicalDevice::create([
			'name'=>'E داخلى إصابات',
			'location'=>'Clinics'
		]);
		MedicalDevice::create([
			'name'=>'Ortho OT',
			'location'=>'Clinics'
		]);
    }
}
