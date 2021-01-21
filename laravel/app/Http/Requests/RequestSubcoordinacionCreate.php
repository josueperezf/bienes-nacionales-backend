<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestSubcoordinacionCreate extends FormRequest
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

    public function rules()
    {
        return [
            'coordinacion_id' =>'required',
            'ciudad' =>'required|min:3|max:100',
            'nombre'    =>'required|min:3|max:100|unique:subcoordinacions',
            'direccion'   =>'required|min:3|max:100'
        ];
    }
}