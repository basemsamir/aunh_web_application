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
		return view('admin.reservation_places.index', compact('places','panel_title') );
	}
	public function dep_index()
	{
		$deps=Department::all();
		$panel_title='بيانات الأقسام';
		return view('admin.departments.index', compact('deps','panel_title') );
	}
	public function doctor_index()
	{
		$docs=Doctor::all();
		$panel_title='بيانات أطباء الأشعة';
		return view('admin.doctors.index', compact('docs','panel_title') );
	}
	public function medical_device_index()
	{
		$devices=MedicalDevice::all();
		$panel_title='بيانات الأجهزة';
		return view('admin.medical_devices.index', compact('devices','panel_title') );
	}
	public function procedure_index()
	{
		$procs=Procedure::with('proceduretype')->get();
		//dd($procs);
		$panel_title='بيانات الفحوصات';
		return view('admin.procedures.index', compact('procs','panel_title') );
	}
	public function user_index()
	{
		$users=User::all();
		$panel_title='بيانات المستخدمين';
		return view('admin.users.index', compact('users','panel_title') );
	}
}
