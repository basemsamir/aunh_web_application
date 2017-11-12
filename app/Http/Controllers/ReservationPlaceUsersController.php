<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use App\ReservationPlace;
use App\User;
use App\Http\Requests;

class ReservationPlaceUsersController extends Controller
{
    private $action_index='res_user_index';
    private $base_folder_name='admin.users';
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
        $panel_title='بيانات مستخدمين مكاتب الحجز';
        $res_user_active='true';
        $users=User::lists('name','id');
        $reservation_places=ReservationPlace::lists('name','id');
        return view($this->base_folder_name.'.res_user_store',compact('panel_title','users','reservation_places','res_user_active'));
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
        $rules['res_id']='required';
        $rules['user_id']='required';
        $this->validate($request,$rules);

        $res_place=ReservationPlace::find($request->input('res_id'));
        $user=User::find($request->input('user_id'));
        if($res_place->users()->where('user_id',$request->input('user_id'))->count() > 0)
          return redirect()->action('AdminController@'.$this->action_index)->withFailureMessage('المستخدم '.$user->name." موجود فى مكتب الحجز ".$res_place->name );
        else {
          $res_place->users()->attach($request->input('user_id'));
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

        $rules['user_id']='required';
        $this->validate($request,$rules);
        $res_place=ReservationPlace::find($id);
        $res_place->users()->detach($request->input('user_id'));
        return redirect()->action('AdminController@'.$this->action_index)->withSuccessMessage(Lang::get('flash_messages.success'));

    }
}
