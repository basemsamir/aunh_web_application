<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ProcedureRequest extends Request
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
        $rules['proc_ris_id']='required';
        if(!isset(request()->id))
        {
            $rules['name']='required|min:4|max:20|unique:procedures,name';
        }
        else{
            $rules['name']='required|min:4|max:20|unique:procedures,name,'.request()->id;
        }      
        return $rules;
    }
    public function messages()
    {
        # code...
        $message['name.unique']="أسم الفحص/التحليل موجود من قبل";
        return $message;
    }
}
