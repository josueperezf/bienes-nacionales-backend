<?php

namespace App\Http\Controllers;

use App\Coordinacion;
use App\Subcoordinacion;
use App\DependenciaUsuaria;
use App\UnidadAdministrativa;
use App\TipoDependenciaUsuaria;
use App\Bien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Http\Requests\RequestDependenciaUsuariaCreate;
use App\Http\Requests\RequestDependenciaUsuariaUpdate;
class DependenciaUsuariaController extends Controller
{
    public function index(Request $request)
    {
        return DependenciaUsuaria::Buscador($request->all());
    }

    public function create()
    {
        return $tipoDependenciaUsuaria=TipoDependenciaUsuaria::where('id','<>','3')->select('id','nombre')->get();
    }

    public function store(RequestDependenciaUsuariaCreate $request)
    {
        $dependenciaUsuaria=new DependenciaUsuaria($request->all());
        $dependenciaUsuaria->save();
        return Response::json(['message'=>'Operacion Exitosa'],201);
    }

    public function porUnidadAdministrativa($unidad_administrativa_id)
    {
        return [
            'dependenciaUsuarias'=>DependenciaUsuaria::where('unidad_administrativa_id','=',$unidad_administrativa_id)->get()
        ];
    }
    
    public function show(DependenciaUsuaria $dependenciaUsuaria)
    {
        $biens=Bien::
        join("biens_movimientos",function($join){
            $join->on("biens_movimientos.bien_id" ,"=", "biens.id");
            $join->where('biens_movimientos.actual','=',2);
        })
        ->leftJoin("marcas","marcas.id" ,"=", "biens.marca_id")
        ->leftJoin("denominacions","denominacions.id" ,"=", "biens.denominacion_id")
        ->where('biens_movimientos.dependencia_usuaria_id','=',$dependenciaUsuaria->id)
        ->select(['biens.*',
                    'marcas.nombre as marca_nombre',
                    'marcas.id as marca_id',
                    'denominacions.nombre as denominacion_nombre',
                    'denominacions.id as denominacion_id',
                ])->get();
        $dependenciaUsuaria->unidadAdministrativa;
        return [
            'biens'=>$biens,
            'dependenciaUsuarias'=>$dependenciaUsuaria,
        ];
    }

    public function edit(DependenciaUsuaria $dependenciaUsuaria)
    {
        $coordinacionSeleccionada= $dependenciaUsuaria->unidadAdministrativa->subcoordinacion->coordinacion;
        $subcoordinacionSeleccionada= $dependenciaUsuaria->unidadAdministrativa->subcoordinacion;
        $subcoordinaciones=Subcoordinacion::where('coordinacion_id','=',$coordinacionSeleccionada->id)->select('id','nombre')->get();
        $unidadAdministrativas= UnidadAdministrativa::where('subcoordinacion_id','=',$subcoordinacionSeleccionada->id)->select('id','nombre')->get();
        $aux=UnidadAdministrativa::
                join('dependencia_usuarias','dependencia_usuarias.unidad_administrativa_id','=','unidad_administrativas.id')
                ->where('subcoordinacion_id','=',$subcoordinacionSeleccionada->id)
                ->where('dependencia_usuarias.tipo_dependencia_usuaria_id','=',1)
                //->where('dependencia_usuarias.id','=',$dependenciaUsuaria->id)
                ->where('dependencia_usuarias.deleted_at','=',null)
                ->select('dependencia_usuarias.*')
                ->first();
        if($aux){
            if($aux->dependencia_usuaria_id==$dependenciaUsuaria->id)
                $aux=1;
            else
                $aux=0;
        }else 
        $aux=1;
        //return $aux;
        $tipoDependenciaUsuarias=TipoDependenciaUsuaria::where('id','<>','3')
                                    ->whereIn('id',[2,$aux,$dependenciaUsuaria->tipo_dependencia_usuaria_id])
                                    ->select('id','nombre')->get();
        $coordinaciones= Coordinacion::select('id','nombre')->get();
        return [
            'coordinaciones'=>$coordinaciones,
            'coordinacionSeleccionada'=>$coordinacionSeleccionada,
            'subcoordinaciones'=>$subcoordinaciones,
            'subcoordinacionSeleccionada'=>$subcoordinacionSeleccionada,
            'tipoDependenciaUsuarias'=>$tipoDependenciaUsuarias,
            'unidadAdministrativas'=>$unidadAdministrativas,
            'dependenciaUsuaria'=> $dependenciaUsuaria
        ];
    }

    public function update(Request $request, $id)
    {
        $totalAlmacenEnDependenciaUsuaria=0;
        $dependenciaUsuaria=DependenciaUsuaria::withTrashed()->where('id','=',$id)->first();
        if(($request->deleted_at==null) and  ($dependenciaUsuaria->deleted_at!=null)){
            if($dependenciaUsuaria->tipo_dependencia_usuaria_id==1){
                $totalAlmacenEnDependenciaUsuaria=DependenciaUsuaria::where('id','!=',$id)->where('tipo_dependencia_usuaria_id','=',1)->count();
            }
            if($totalAlmacenEnDependenciaUsuaria>0)
            {
                return  Response::json(
                    [
                        'errors'=>[
                            'dependencia'=>
                            ['No pueden existir dos almacenes activos de manera simultaneas en la misma coordinacion']
                            ]
                        ], 422);
            }else{        
                $dependenciaUsuaria->restore();
            }
        }
        else{
            $dependenciaUsuaria=DependenciaUsuaria::where('id','=',$id)->first();
            if($request->tipo_dependencia_usuaria_id!=1)
                $totalAlmacenEnDependenciaUsuaria=0;
            else
                $totalAlmacenEnDependenciaUsuaria=DependenciaUsuaria::where('id','!=',$id)->where('tipo_dependencia_usuaria_id','=',1)->count();
            if($totalAlmacenEnDependenciaUsuaria>0)
            {
                return  Response::json(
                    [
                        'errors'=>[
                            'dependencia'=>
                            ['No pueden existir dos almacenes activos de manera simultaneas en la misma coordinacion']
                            ]
                        ], 422);
            }else{        
                $dependenciaUsuaria->fill($request->all())->update();
            }
        }
        return Response::json(['mensaje'=>'Operacion Exitosa'],200);
    }

    public function destroy(DependenciaUsuaria $dependenciaUsuaria)
    {
        $dependenciaUsuaria->delete();
        return Response::json(['message'=>'Eliminacion Exitosa'],200);
    }
}