<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use App\Http\Requests;
use App\Wsconfig;

class WsConfigController extends Controller
{
    private $action_index='wsconfig_index';
    private $base_folder_name='admin.wsconfig';
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
        $panel_title='بيانات إعدادات التواصل مع خدمة الويب الخاصة بالنظام الأشعة';;
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
        $rules['url']='required|url';
        $rules['sending_app']='required';
        $rules['receiving_app']='required';
        $rules['sending_fac']='required';
        $rules['receiving_fac']='required';
        $this->validate($request,$rules);

        Wsconfig::create($request->all());
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
        $wsconfig=Wsconfig::find($id);
        $panel_title='بيانات إعدادات التواصل مع خدمة الويب الخاصة بالنظام الأشعة';;
        return view($this->base_folder_name.'.edit',compact('panel_title','wsconfig'));
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
        $rules['url']='required|url';
        $rules['sending_app']='required';
        $rules['receiving_app']='required';
        $rules['sending_fac']='required';
        $rules['receiving_fac']='required';
        $this->validate($request,$rules);

        Wsconfig::find($id)->update($request->all());

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
        $device=Wsconfig::find($id)->delete();
        return redirect()->action('AdminController@'.$this->action_index)->withSuccessMessage(Lang::get('flash_messages.success'));

    }
}
