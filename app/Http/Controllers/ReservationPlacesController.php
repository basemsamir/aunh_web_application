<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use App\Http\Requests;
use App\ReservationPlace;
use DB;
class ReservationPlacesController extends Controller
{
    private $action_index='res_index';
    private $base_folder_name='admin.reservation_places';
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $panel_title='بيانات أماكن الحجز';
        $res_active='true';
        return view($this->base_folder_name.'.store',compact('panel_title','res_active'));
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
        $message['name.unique']='أسم المكتب موجود من قبل';
        $this->validate($request,$rules,$message);
        ReservationPlace::create($request->all());
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
        $place=ReservationPlace::find($id);
        $panel_title='بيانات أماكن الحجز';
        $res_active='true';
        return view($this->base_folder_name.'.edit',compact('place','panel_title','res_active'));
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
        $rules['name']='required|min:4|max:20|unique:reservation_places,name,'.$id;
        $message['name.unique']='أسم المكتب موجود من قبل';
        $this->validate($request,$rules,$message);
        $place=ReservationPlace::find($id);
        $place->name=$request->input('name');
        $place->save();
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
        $place=ReservationPlace::find($id);

        if($place->users()->count() > 0)
          return redirect()->action('AdminController@res_index')->withFailureMessage('لا يمكن حذف '.$place->name.' لوجود مستخدمين به ');
        else {
          DB::beginTransaction();
          try {
              $place->delete();
              DB::commit();
              return redirect()->action('AdminController@'.$this->action_index)->withSuccessMessage(Lang::get('flash_messages.success'));
          } catch (\Exception $e) {
              DB::rollBack();
              return redirect()->action('AdminController@'.$this->action_index)->withFailureMessage(Lang::get('flash_messages.failed'));
          }
        }
    }
}
