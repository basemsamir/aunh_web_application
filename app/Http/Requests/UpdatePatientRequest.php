<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UpdatePatientRequest extends Request
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
            'name'=>'required|min:2|max:100',
            'gender'=>'required',
            'sin'=>'size:14|unique:patients,sin',
            'address'=>'min:3',
            'nationality'=>'min:3',
            'phone_num'=>'min:4|max:20',
            'birthdate' => 'required|date',
            'sin'=>'numeric|sin_format|unique:patients,sin,'.request()->id,
        ];
    }
    public function messages()
    {
        return ['sin.unique'=>'الرقم القومي موجود من قبل'];
    }
}
