<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Routing\Route;
class RequestSubcoordinacionUpdate extends FormRequest
{
    public function __construct(Route $route)
    {
        $this->route=$route;
    }

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
            'coordinacion_id' =>'required',
            'ciudad' =>'required|min:3|max:100',
            'nombre'    =>'required|min:3|max:100|unique:subcoordinacions,nombre,'.$this->route->__get('subcoordinacion'),
            'direccion'   =>'required|min:3|max:100'
        ];
    }
}
