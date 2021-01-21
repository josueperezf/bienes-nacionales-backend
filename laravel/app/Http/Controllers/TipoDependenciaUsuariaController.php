<?php

namespace App\Http\Controllers;
use App\TipoDependenciaUsuaria;
use App\DependenciaUsuaria;
use Illuminate\Http\Request;

class TipoDependenciaUsuariaController extends Controller
{
    public function porUnidadAdministrativa($unidad_administrativa_id)
    {
        //no estoy haciendo con carajo con esta variable $unidad_administrativa_id ya q perimito q solo haya un unico almacen en toda la empresa 
        //el tres es para q  no retorne el tipo de dependencia eliminacion
        $notIn=[3];
        $totalAlmacenEnDependenciaUsuaria=DependenciaUsuaria::where('tipo_dependencia_usuaria_id','=',1)->count();
        if($totalAlmacenEnDependenciaUsuaria>0){
            //el dos es para q no permita crear mas almacen
            $notIn[1]=1;
        }
        $tipoDependenciaUsuaria=TipoDependenciaUsuaria::wherenotin('id',$notIn)->get();
        return $tipoDependenciaUsuaria;
    }
}