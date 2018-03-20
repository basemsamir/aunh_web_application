<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use App\MedicalDevice;
use App\MedicalDeviceType;
use App\MedicalDeviceCategory;
use App\Http\Requests;
use App\Http\Requests\MedicalDeviceRequest;

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
         $categories=MedicalDeviceCategory::lists('arabic_name','id');
         $types=MedicalDeviceType::where('medical_device_category_id',$categories->keys()->first())->lists('name','id');
         return view($this->base_folder_name.'.store',compact('panel_title','dev_active','categories','types'));
     }

     /**
      * Store a newly created resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @return \Illuminate\Http\Response
      */
     public function store(MedicalDeviceRequest $request)
     {
         MedicalDevice::create([
             'name'=>$request->name,
             'medical_device_type_id'=>$request->medical_device_type_id,
             'location'=>$request->location
         ]);
         return redirect()->action('AdminController@'.$this->action_index)->withSuccessMessage(Lang::get('flash_messages.success'));
     }
     /**
      * Show the form for editing the specified resource.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function edit(MedicalDevice $medical_device)
     {
         //
         $panel_title='بيانات الأجهزة';
         $dev_active='true';
         $categories=MedicalDeviceCategory::lists('arabic_name','id');
         $types=MedicalDeviceType::where('medical_device_category_id', $medical_device->medical_device_type->category->id)->lists('name','id');
         return view($this->base_folder_name.'.edit',compact('medical_device','panel_title','dev_active','categories','types'));
     }

     /**
      * Update the specified resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function update(MedicalDeviceRequest $request, MedicalDevice $medical_device)
     {
         $medical_device->update($request->all());
         return redirect()->action('AdminController@'.$this->action_index)->withSuccessMessage(Lang::get('flash_messages.success'));
     }

     /**
      * Remove the specified resource from storage.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function destroy(MedicalDevice $medical_device)
     {
         //
         if($medical_device->procedures()->count() > 0)
            return redirect()->action('AdminController@'.$this->action_index)->withFailureMessage('لا يمكن حذف '.$medical_device->name.' لوجود فحوصات به ');
         else {
             $medical_device->delete();
             return redirect()->action('AdminController@'.$this->action_index)->withSuccessMessage(Lang::get('flash_messages.success'));
         }
     }

    public function getMedicalDeviceTypesApi(Request $request)
    {
        $types=MedicalDeviceType::where('medical_device_category_id',$request->category_id)
                                 ->get(['id','name'])
                                 ->toArray();
        return response()->json(['types'=>$types]);
    }
}
