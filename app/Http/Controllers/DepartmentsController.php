<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use App\Http\Requests;
use App\Department;

class DepartmentsController extends Controller
{
    private $action_index='dep_index';
    private $base_folder_name='admin.departments';
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
        $panel_title='بيانات الأقسام';
        $dep_active='true';
        return view($this->base_folder_name.'.store',compact('panel_title','dep_active'));
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
        $rules['name']='required|min:4|max:20|unique:departments,name';
        $message['name.unique']='أسم القسم موجود من قبل';
        $this->validate($request,$rules,$message);
        Department::create($request->all());
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
        $panel_title='بيانات الأقسام';
        $dep_active='true';
        $dep=Department::find($id);
        return view($this->base_folder_name.'.edit',compact('dep','panel_title','dep_active'));
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
        $rules['name']='required|min:4|max:20|unique:departments,name,'.$id;
        $message['name.unique']='أسم القسم موجود من قبل';
        $this->validate($request,$rules,$message);
        Department::find($id)->update($request->all());
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
        $dep=Department::find($id);
        $dep->delete();
        return redirect()->action('AdminController@'.$this->action_index)->withSuccessMessage(Lang::get('flash_messages.success'));

    }
}
