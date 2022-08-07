<?php

namespace App\Http\Requests;

use App\Rules\UniqueEdit;
use Illuminate\Foundation\Http\FormRequest;

class CategoryEditReq extends FormRequest
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
        $rule = [
           
            'category_name' => 'required'
        ];

      
        if (parent::all()['category_name_old'] != parent::all()['category_name']) {
            $rule['category_name'] = 'required|unique:App\Models\Category,category_name';
        }

      

        return $rule;
    }

    public function messages()
    {
        $msg = [
         

            "category_name.required" => "Category name is required !",
        ];
        if (parent::all()['category_name_old'] != parent::all()['category_name']) {
            $msg['category_name.unique'] = 'Try another value or use old value!';
      
        }

        return $msg;
    }
}
