<?php

namespace App\Http\Controllers;

use App\UnidadAdministrativa;
//use App\DependenciaUsuaria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Http\Requests\RequestUnidadAdministrativaCreate;
use App\Http\Requests\RequestUnidadAdministrativaUpdate;
class UnidadAdministrativaController extends Controller
{
    public function index(Request $request)
    {
        return UnidadAdministrativa::Buscador($request->all());
    }

    public function create()
    {
        //
    }
    public function ConDependenciaAlmacen($subcoordinacion_id){
        $data=UnidadAdministrativa::where('subcoordinacion_id','=',$subcoordinacion_id)
                    ->leftJoin('dependencia_usuarias','dependencia_usuarias.unidad_administrativa_id','unidad_administrativas.id')
                    ->where('dependencia_usuarias.tipo_dependencia_usuaria_id','=',1)
                    ->select(['dependencia_usuarias.id as dependencia_usuaria_id','dependencia_usuarias.nombre','unidad_administrativas.nombre as unidad_administrativa_nombre'])
                    ->get();
        return Response::json(['dependenciaUsuariaAlmacen'=>$data],201);
        
    }
    public function store(RequestUnidadAdministrativaCreate $request)
    {
        $unidadAdministrativa= new UnidadAdministrativa($request->all());
        $unidadAdministrativa->save();
        return Response::json(['message'=>'Operacion Exitosa'],201);
    }

    public function show(UnidadAdministrativa $unidadAdministrativa)
    {
        if($unidadAdministrativa->id==1)
            return  Response::json(['errors'=>['id'=>['unidad administrativa no autoriazada']]], 422);
        $unidadAdministrativa->subcoordinacion;
        $unidadAdministrativa->dependenciaUsuarias;
        return Response::json(['unidadAdministrativa'=>$unidadAdministrativa],200);
        
        //
    }

    public function edit(UnidadAdministrativa $unidadAdministrativa)
    {
        //
    }

    public function update(RequestUnidadAdministrativaUpdate $request, $id)
    {
        $unidadAdministrativa=UnidadAdministrativa::withTrashed()->where('id','=',$id)->first();
        if(($request->deleted_at==null) and  ($unidadAdministrativa->deleted_at!=null))
            $unidadAdministrativa->restore();
        else
            $unidadAdministrativa->fill($request->all())->update();
        return Response::json(['mensaje'=>'Operacion Exitosa'],200);
    }
    public function destroy(UnidadAdministrativa $unidadAdministrativa)
    {
        $unidadAdministrativa->delete();
        return Response::json(['message'=>'Eliminacion Exitosa'],200);
    }
}
