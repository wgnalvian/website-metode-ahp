<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryCompar extends FormRequest
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
        if(preg_match("/category_compar_[0-9]/",$key)){
            $rule[$key] = 'required';       
        }
       }

       return $rule;
    }

    public function messages()
    {
        foreach (parent::all() as $key => $value) {
            if(preg_match("/category_compar_[0-9]/",$key)){
                $msg["$key.required"] = 'Compar Value cannot be null !';       
            }
           }
        
           return $msg;
    }
}
