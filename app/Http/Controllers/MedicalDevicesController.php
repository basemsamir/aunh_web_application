<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use App\MedicalDevice;
use App\MedicalDeviceType;
use App\Http\Requests;

class MedicalDevicesController extends Controller
{

    private $action_index='medical_device_index';
    private $base_folder_name='admin.medical_devices';
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function create()
     {
         //
         $panel_title='بيانات الأجهزة';
         $dev_active='true';
         $types=MedicalDeviceType::lists('name','id');
         return view($this->base_folder_name.'.store',compact('panel_title','dev_active','types'));
     }

     /**
      * Store a newly created resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @return \Illuminate\Http\Response
      */
     public function store(Request $request)
     {
         //
         $rules['name']='required|min:4|max:20|unique:medical_devices,name';
         $rules['medical_device_type_id']='required';
         $rules['location']='min:4|max:20';
         $message['name.unique']="أسم الجهاز موجود من قبل";
         $this->validate($request,$rules,$message);
         MedicalDevice::create($request->all());
         return redirect()->action('AdminController@'.$this->action_index)->withSuccessMessage(Lang::get('flash_messages.success'));
     }
     /**
      * Show the form for editing the specified resource.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function edit($id)
     {
         //
         $panel_title='بيانات الأجهزة';
         $dev_active='true';
         $device=MedicalDevice::find($id);
         $types=MedicalDeviceType::lists('name','id');
         return view($this->base_folder_name.'.edit',compact('device','panel_title','dev_active','types'));
     }

     /**
      * Update the specified resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function update(Request $request, $id)
     {
         //
         $rules['name']='required|min:4|max:20|unique:medical_devices,name,'.$id;
         $rules['medical_device_type_id']='required';
         $rules['location']='min:4|max:20';
         $message['name.unique']="أسم الجهاز موجود من قبل";
         $this->validate($request,$rules,$message);
         $device=MedicalDevice::find($id)->update($request->all());
         return redirect()->action('AdminController@'.$this->action_index)->withSuccessMessage(Lang::get('flash_messages.success'));
     }

     /**
      * Remove the specified resource from storage.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function destroy($id)
     {
         //
         $device=MedicalDevice::find($id);

         if($device->procedures()->count() > 0)
           return redirect()->action('AdminController@'.$this->action_index)->withFailureMessage('لا يمكن حذف '.$device->name.' لوجود فحوصات به ');
         else {
             $device->delete();
             return redirect()->action('AdminController@'.$this->action_index)->withSuccessMessage(Lang::get('flash_messages.success'));
         }
     }
}
