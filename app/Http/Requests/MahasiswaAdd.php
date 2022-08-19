<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MahasiswaAdd extends FormRequest
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
            'mahasiswa_name' => 'required',
            'mahasiswa_nim' => 'required|unique:App\Models\Mahasiswa,nim'
        ];
    }
    public function messages()
    {
        return [

            'mahasiswa_name.required' => 'Mahasiswa name is required !',
            'mahasiswa_nim.required' => 'Mahasiswa nim is required !',
            'mahasiswa_nim.unique' => 'Mahasiswa nim  has been used !  !',
        ];
    }
}
