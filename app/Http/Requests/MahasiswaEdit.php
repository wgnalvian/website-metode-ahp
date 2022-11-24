<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MahasiswaEdit extends FormRequest
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
           
            'mahasiswa_name' => 'required',
            'mahasiswa_nim' => 'required'
        ];

      
        if (parent::all()['mahasiswa_nim_old'] != parent::all()['mahasiswa_nim']) {
            $rule['mahasiswa_nim'] = 'required|unique:App\Models\Mahasiswa,nim';
        }

      

        return $rule;
    }

    public function messages()
    {
        $msg = [
         

            "mahasiswa_name.required" => "Mahasiswa name is required !",
            "mahasiswa_nim.required" => "Mahasiswa nim is required !",
        ];
        if (parent::all()['mahasiswa_nim_old'] != parent::all()['mahasiswa_nim']) {
            $msg['mahasiswa_nim.unique'] = 'Try another value or use old value!';
      
        }

        return $msg;
    }
}
