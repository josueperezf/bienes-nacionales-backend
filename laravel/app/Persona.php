<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $fillable=['cedula','apellidos','nombres','estatus'];
    public function scopeBuscador($query,$buscar,$sort,$order)
    {
        if($sort=='created')
        $sort='id';
        //http://127.0.0.1:8000/api/personas?q=repo:angular/material2&sort=nombres&order=asc&p
        return $query->where('cedula','like','%'.$buscar.'%')
                        ->orWhere('apellidos', 'LIKE', "%$buscar%")
                        ->orWhere('nombres', 'LIKE', "%$buscar%")
                        ->orderBy($sort,$order);
    }

}
