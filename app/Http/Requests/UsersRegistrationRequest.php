<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UsersRegistrationRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'name'=>'required|min:4|max:20|unique:users,name',
            'email'=>'required|email|unique:users,email',
            'role_id'=>'required',
            'password'=>'required|min:6|max:20|confirmed',
        ];
    }
    public function messages()
    {
        return[
            'name.unique'=>"أسم المستخدم موجود من قبل",
            'email.unique'=>"البريد الألكتروني موجود من قبل",
            'password.confirmed'=>"كلمتي المرور غير متطابقتين",
        ];
    }
}
