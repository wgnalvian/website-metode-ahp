<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubCategoryEdit extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function rules()
    {
        $rule = [
            'category_id' => 'required|exists:categories,id',
            'subcategory_name' => 'required'
        ];

      
      
      

        return $rule;
    }

    public function messages()
    {
        $msg = [
         
            'category_id.required' => 'Category is required !',
            'category_id.exists' => 'Worng category !',
            "subcategory_name.required" => "Subcategory name is required !",
        ];
     

        return $msg;
    }
}
