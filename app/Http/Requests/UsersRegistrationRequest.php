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
        $rules['role_id']='required';
        if(isset(request()->id)){
            $rules['name']='required|min:4|max:20|unique:users,name,'.request()->id;
            $rules['email']='required|email|unique:users,email,'.request()->id;
            $rules['password']='min:6|max:20|confirmed';
        }
        else{
            $rules['name']='required|min:4|max:20|unique:users,name';
            $rules['email']='required|email|unique:users,email';
            $rules['password']='required|min:6|max:20|confirmed';
        }
        return $rules;
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
