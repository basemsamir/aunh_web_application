<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use App\User;
use App\Http\Requests;

class UsersController extends Controller
{
  private $action_index='user_index';
  private $base_folder_name='admin.users';

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function create()
   {
       //
       $panel_title='بيانات المستخدمين';
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
       $rules['name']='required|min:4|max:20|unique:users,name';
       $rules['email']='required|email|unique:users,email';
       $rules['password']='required|min:6|max:20|confirmed';
       $message['name.unique']="أسم المستخدم موجود من قبل";
       $message['email.unique']="البريد الألكتروني موجود من قبل";
       $message['password.confirmed']="كلمتي المرور غير متطابقتين";
       $this->validate($request,$rules,$message);
       $user= new User;
       $user->name=$request->input('name');
       $user->email=$request->input('email');
       $user->password=bcrypt($request->input('password'));
       $user->save();
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
       $panel_title='بيانات المستخدمين';
       $user=User::find($id);
       return view($this->base_folder_name.'.edit',compact('user','panel_title'));
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
       $rules['name']='required|min:4|max:20|unique:users,name,'.$id;
       $rules['email']='required|email|unique:users,email,'.$id;
       $rules['password']='min:6|max:20|confirmed';
       $message['name.unique']="أسم المستخدم موجود من قبل";
       $message['email.unique']="البريد الألكتروني موجود من قبل";
       $message['password.confirmed']="كلمتي المرور غير متطابقتين";
       $this->validate($request,$rules,$message);
       $user=User::find($id);
       $user->name=$request->input('name');
       $user->email=$request->input('email');
       if($request->input('password') != "")
        $user->password=bcrypt($request->input('password'));
       $user->save();
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
       $user=User::find($id);

       if($user->visits()->count() > 0)
         return redirect()->action('AdminController@'.$this->action_index)->withFailureMessage('لا يمكن حذف '.$user->name.' لحجزه الكثير من المواعيد');
       else {
           $user->delete();
           return redirect()->action('AdminController@'.$this->action_index)->withSuccessMessage(Lang::get('flash_messages.success'));
       }
     }
}
