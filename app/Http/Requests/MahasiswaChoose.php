<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MahasiswaChoose extends FormRequest
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

       foreach (parent::all() as $key => $value) {
        if(preg_match("/category_id_[0-9]/",$key)){
            $rule[$key] = 'required';       
        }
       }

     

       return $rule;
    }

    public function messages()
    {
        foreach (parent::all() as $key => $value) {
            if(preg_match("/category_id_[0-9]/",$key)){
                $msg["$key.required"] = 'Value cannot be null !';       
            }
           }

         
        
           return $msg;
    }
}
