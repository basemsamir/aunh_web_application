<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use App\Doctor;
use App\Http\Requests;

class DoctorsController extends Controller
{

    private $action_index='doctor_index';
    private $base_folder_name='admin.doctors';
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $panel_title='بيانات أطباء الأشعة';
        return view($this->base_folder_name.'.store',compact('panel_title'));
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
        $rules['name']='required|min:4|max:20|unique:doctors,name';
        $message['name.unique']='أسم الطبيب موجود من قبل';
        $this->validate($request,$rules,$message);
        Doctor::create($request->all());
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
        $panel_title='بيانات أطباء الأشعة';
        $doc=Doctor::find($id);
        return view($this->base_folder_name.'.edit',compact('doc','panel_title'));
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
        $rules['name']='required|min:4|max:20|unique:doctors,name,'.$id;
        $message['name.unique']='أسم الطبيب موجود من قبل';
        $this->validate($request,$rules,$message);
        $doc=Doctor::find($id);
        $doc->name=$request->input('name');
        $doc->save();
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
        $doc=Doctor::find($id);
        $doc->delete();
        return redirect()->action('AdminController@'.$this->action_index)->withSuccessMessage(Lang::get('flash_messages.success'));
    }
}
