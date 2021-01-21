<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestDependenciaUsuariaCreate extends FormRequest
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
            'tipo_dependencia_usuaria_id' =>'required',
            'unidad_administrativa_id' =>'required',
            'nombre'    =>'required|min:3|max:100',
        ];
    }
}
