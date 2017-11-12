<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\ReservationPlace;
use App\Department;
use App\Doctor;
use App\MedicalDevice;
use App\Procedure;
use App\User;
use App\Wsconfig;

class AdminController extends Controller
{
    //

	public function __construct()
  {
      $this->middleware('admin');
  }

	public function index(){
		return view('admin.index');
	}

	public function res_index()
	{
		$places=ReservationPlace::all();
		$panel_title='بيانات أماكن الحجز';
		$res_active='true';
		return view('admin.reservation_places.index', compact('places','panel_title','res_active') );
	}
	public function dep_index()
	{
		$deps=Department::all();
		$panel_title='بيانات الأقسام';
		$dep_active='true';
		return view('admin.departments.index', compact('deps','panel_title','dep_active') );
	}
	public function doctor_index()
	{
		$docs=Doctor::all();
		$panel_title='بيانات أطباء الأشعة';
		$doc_active='true';
		return view('admin.doctors.index', compact('docs','panel_title','doc_active') );
	}
	public function medical_device_index()
	{
		$devices=MedicalDevice::all();
		$panel_title='بيانات الأجهزة';
		$dev_active='true';
		return view('admin.medical_devices.index', compact('devices','panel_title','dev_active') );
	}
	public function procedure_index()
	{
		$procs=Procedure::with('proceduretype')->get();
		//dd($procs);
		$panel_title='بيانات الفحوصات';
		$proc_active='true';
		return view('admin.procedures.index', compact('procs','panel_title','proc_active') );
	}
	public function user_index()
	{
		$users=User::all();
		$panel_title='بيانات المستخدمين';
		$user_active='true';
		return view('admin.users.index', compact('users','panel_title','user_active') );
	}
	public function res_user_index()
	{
		$res_users=ReservationPlace::all();
		$panel_title='بيانات مستخدمين مكاتب الحجز';
		$res_user_active='true';
		return view('admin.users.res_user_index', compact('res_users','panel_title','res_user_active') );
	}
	public function device_proc_index()
	{
		$device_procs=MedicalDevice::all();
  	$panel_title='بيانات فحوصات أجهزة الأشعة';
		$dev_proc_active='true';
		return view('admin.procedures.device_proc_index', compact('device_procs','panel_title','dev_proc_active') );
	}
	public function wsconfig_index($value='')
	{
			$configs= Wsconfig::all();
			$panel_title='بيانات إعدادات التواصل مع خدمة الويب الخاصة بالنظام الأشعة';;
			return view('admin.wsconfig.index', compact('configs','panel_title'));
	}
}
