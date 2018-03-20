<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use App\Procedure;
use App\ProcedureType;
use App\Http\Requests;
use App\Http\Requests\ProcedureRequest;

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
  public function store(ProcedureRequest $request)
  {
      Procedure::create($request->all());
      return redirect()->action('AdminController@'.$this->action_index)->withSuccessMessage(Lang::get('flash_messages.success'));
  }


  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit(Procedure $procedure)
  {
      //
      $panel_title='بيانات الفحوصات';
      $proc_active='true';
      $proceduretypes=ProcedureType::lists('name','id');
      return view($this->base_folder_name.'.edit',compact('procedure','panel_title','proceduretypes','proc_active'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(ProcedureRequest $request,Procedure $procedure)
  {
      $procedure->update($request->all());
      return redirect()->action('AdminController@'.$this->action_index)->withSuccessMessage(Lang::get('flash_messages.success'));
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy(Procedure $procedure)
  {
      $procedure->delete();
      return redirect()->action('AdminController@'.$this->action_index)->withSuccessMessage(Lang::get('flash_messages.success'));
  }
}
