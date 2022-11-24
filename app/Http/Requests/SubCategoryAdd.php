<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubCategoryAdd extends FormRequest
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
            'category_id' => 'required|exists:categories,id',
            'subcategory_name' => 'required|unique:sub_categories,subcategory_name'
           
        ];
    }

    public function messages()
    {
        return [
            'category_id.required' => 'Choose category !',
            'category_id.exists' => 'Wrong category',
            'subcategory_name.required' => 'SubCategory name is required !',
            'subcategory_name.unique' => 'Subcatregory name has been taken'
           
        ];
    }
    
}
