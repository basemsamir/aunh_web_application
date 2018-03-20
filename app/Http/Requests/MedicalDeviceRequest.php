<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class MedicalDeviceRequest extends Request
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
        $rules['medical_device_type_id']='required';
        $rules['location']='min:4|max:20';
        if(!isset(request()->id))
        {
            $rules['name']='required|min:4|max:20|unique:medical_devices,name';
        }
        else{
            $rules['name']='required|min:4|max:20|unique:medical_devices,name,'.request()->id;
        }
        return $rules;
    }
    public function messages()
    {
        # code...
        $message['name.unique']="أسم الجهاز موجود من قبل";
        return $message;
    }
}
