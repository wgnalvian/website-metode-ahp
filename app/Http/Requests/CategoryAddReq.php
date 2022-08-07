<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryAddReq extends FormRequest
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
            
            'category_name' => 'required|unique:App\Models\Category,category_name'
        ];
    }

    public function messages()
    {
        return [
        
            'category_name.required' => 'Category name is required !',
            'category_name.unique' => 'Category name  has been used !  !',
        ];
    }
}
