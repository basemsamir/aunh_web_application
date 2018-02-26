<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use App\User;
use App\Role;
use App\Http\Requests;
use App\Http\Requests\UsersRegistrationRequest;

class UsersController extends Controller
{
    private $action_index='user_index';
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
       $panel_title='بيانات المستخدمين';
       $user_active='true';
       $roles=Role::lists('arabic_name','id');
       return view($this->base_folder_name.'.store',compact('roles','panel_title','user_active'));
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(UsersRegistrationRequest $request)
   {
       User::create($request->all());
       return redirect()->action('AdminController@'.$this->action_index)->withSuccessMessage(Lang::get('flash_messages.success'));
   }



   /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function edit(User $user)
   {
       //
       $panel_title='بيانات المستخدمين';
       $user_active='true';
       $roles=Role::lists('arabic_name','id');
       return view($this->base_folder_name.'.edit',compact('user','roles','panel_title','user_active'));
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request,User $user)
   {
       $rules['name']='required|min:4|max:20|unique:users,name,'.$user->id;
       $rules['email']='required|email|unique:users,email,'.$user->id;
       $rules['role_id']='required';
       $rules['password']='min:6|max:20|confirmed';

       $message['name.unique']='أسم المستخدم موجود من قبل';
       $message['email.unique']='البريد الألكتروني موجود من قبل';
       $message['password.confirmed']="كلمتي المرور غير متطابقتين";
       $this->validate($request,$rules,$message);
       $user->name=$request->input('name');
       $user->email=$request->input('email');
       $user->role_id=$request->input('role_id');
       if($request->input('password') != "")
            $user->password=$request->input('password');
       $user->save();
       return redirect()->action('AdminController@'.$this->action_index)->withSuccessMessage(Lang::get('flash_messages.success'));
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function destroy(User $user)
   {
       if($user->visits()->count() > 0)
         return redirect()->action('AdminController@'.$this->action_index)->withFailureMessage('لا يمكن حذف '.$user->name.' لحجزه الكثير من المواعيد');
       else {
           $user->delete();
           return redirect()->action('AdminController@'.$this->action_index)->withSuccessMessage(Lang::get('flash_messages.success'));
       }
     }
}
