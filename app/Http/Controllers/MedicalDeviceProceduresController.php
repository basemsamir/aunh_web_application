<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use App\Procedure;
use App\MedicalDevice;
use App\Http\Requests;

class MedicalDeviceProceduresController extends Controller
{
  private $action_index='device_proc_index';
  private $base_folder_name='admin.procedures';
  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
      //
      $panel_title='بيانات فحوصات أجهزة الأشعة';
      $procs=Procedure::lists('name','id');
      $devices=MedicalDevice::lists('name','id');
      return view($this->base_folder_name.'.device_proc_store',compact('panel_title','procs','devices'));
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
      $rules['dev_id']='required';
      $rules['proc_id']='required';
      $this->validate($request,$rules);

      $device=MedicalDevice::find($request->input('dev_id'));
      $proc=Procedure::find($request->input('proc_id'));
      if($device->procedures()->where('procedure_id',$request->input('proc_id'))->count() > 0)
        return redirect()->action('AdminController@'.$this->action_index)->withFailureMessage(' الفحص '.$proc->name." محجوز للجهاز ".$device->name );
      else {
        $device->procedures()->attach($request->input('proc_id'));
        return redirect()->action('AdminController@'.$this->action_index)->withSuccessMessage(Lang::get('flash_messages.success'));
      }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id,Request $request)
  {
      //

      $rules['proc_id']='required';
      $this->validate($request,$rules);
      $device=MedicalDevice::find($id);
      $device->procedures()->detach($request->input('proc_id'));
      return redirect()->action('AdminController@'.$this->action_index)->withSuccessMessage(Lang::get('flash_messages.success'));

  }
}
