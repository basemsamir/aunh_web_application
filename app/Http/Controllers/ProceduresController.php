<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use App\Procedure;
use App\ProcedureType;
use App\Http\Requests;

class ProceduresController extends Controller
{
  private $action_index='procedure_index';
  private $base_folder_name='admin.procedures';
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
      $panel_title='بيانات الفحوصات';
      $proc_active='true';
      $proceduretypes=ProcedureType::lists('name','id');
      return view($this->base_folder_name.'.store',compact('panel_title','proceduretypes','proc_active'));
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

      $rules['name']='required|min:4|max:20|unique:procedures,name';
      $rules['proc_ris_id']='required';
      $message['name.unique']='أسم الفحص موجود من قبل';
      $this->validate($request,$rules,$message);
      Procedure::create($request->all());
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
      $panel_title='بيانات الفحوصات';
      $proc_active='true';
      $proc=Procedure::find($id);
      $proceduretypes=ProcedureType::lists('name','id');
      return view($this->base_folder_name.'.edit',compact('proc','panel_title','proceduretypes','proc_active'));
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
      $rules['name']='required|min:4|max:20|unique:procedures,name,'.$id;
      $message['name.unique']='أسم الفحص موجود من قبل';
      $this->validate($request,$rules,$message);
      Procedure::find($id)->update($request->all());
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
      $proc=Procedure::find($id);
      $proc->delete();
      return redirect()->action('AdminController@'.$this->action_index)->withSuccessMessage(Lang::get('flash_messages.success'));

  }
}
