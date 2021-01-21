<?php

namespace App\Http\Requests;
use Illuminate\Routing\Route;
use Illuminate\Foundation\Http\FormRequest;

class RequestPersonaUpdate extends FormRequest
{
    public function __construct(Route $route)
    {
        $this->route=$route;
    }
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'cedula'    =>'required|min:9|max:11|unique:personas,cedula,'.$this->route->__get('persona'),
            'apellidos' =>'required|min:3|max:100',
            'nombres'   =>'required|min:3|max:50'
        ];
    }
}