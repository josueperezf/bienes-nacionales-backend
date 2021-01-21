<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestPersonaCreate extends FormRequest
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
            'cedula'    =>'required|min:9|max:11|unique:personas',
            'apellidos' =>'required|min:3|max:100',
            'nombres'   =>'required|min:3|max:50'
        ];
    }
}
