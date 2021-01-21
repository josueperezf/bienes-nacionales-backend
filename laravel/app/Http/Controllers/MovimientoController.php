<?php

namespace App\Http\Controllers;
use App\Movimiento;
use App\TipoMovimiento;
use App\BiensMovimiento;
use App\DependenciaUsuaria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class MovimientoController extends Controller
{
    public $dataDelOrigen=[];
    public function index(Request $request)
    {
        return Movimiento::Buscador($request->all());
    }

    public function create()
    {
        return[
            'tipoMovimientos'=>TipoMovimiento::where('id','!=','1')->select('id','nombre')->get()
        ];
    }

    public function store(Request $request)
    {
        ($request->fecha)? $fecha=$request->fecha:$fecha=date('Y-m-d h:m:s');
        if(empty($request->detalle_tipo_movimiento_id) and empty($request->bienes))
            return  Response::json(['errors'=>['detalle_tipo_movimiento_id'=>['No posee los requisitos minimos para procesar el movimiento, contacte al programador']]], 422);
        $bienes=collect($request->bienes);
        $exite=true;
        foreach ($request->bienes as $bien) {
            if((!array_key_exists('dependencia_usuaria_id',$bien)) or (!array_key_exists('dependencia_usuaria_destino_id',$bien)) or (!array_key_exists('id',$bien)) )
                $exite=false;
            if($bien['dependencia_usuaria_id']==$bien['dependencia_usuaria_destino_id'])
                $exite=false;
        }
        if(!$exite)
            return  Response::json(['errors'=>['detalle_tipo_movimiento_id'=>['Los Bienes no tienen el formato deseado, contacte al programador']]], 422);
        $biensMovimiento=BiensMovimiento::where('actual','=',2)
                            ->whereIn('dependencia_usuaria_id',$bienes->pluck('dependencia_usuaria_id'))
                            ->whereIn('bien_id',$bienes->pluck('id'))->get();

        if(count($biensMovimiento)!=count($request->bienes))
            return  Response::json(['errors'=>['detalle_tipo_movimiento_id'=>['ha ocurrido ']]], 422);
        
        BiensMovimiento::where('actual','=',2)
                        ->whereIn('dependencia_usuaria_id',$bienes->pluck('dependencia_usuaria_id'))
                        ->whereIn('bien_id',$bienes->pluck('id'))
                        ->update(['actual'=>1]);
        
        $movimiento= new Movimiento(['detalle_tipo_movimiento_id'=>$request->detalle_tipo_movimiento_id,'fecha'=>$fecha]);
        if($movimiento->save()){
            foreach ($request->bienes as $bien) {
                $aux=new BiensMovimiento([
                    'movimiento_id'=>$movimiento->id,
                    'bien_id'=>$bien['id'],
                    'dependencia_usuaria_origen_id'=>$bien['dependencia_usuaria_id'],
                    'dependencia_usuaria_id'=>$bien['dependencia_usuaria_destino_id'],
                    'actual'=>2,
                    ]);
                    $aux->save();

            }
        }
        return Response::json(['movimiento'=>$movimiento, 'message'=>'Operacion Exitosa'],201);

    }

    public function show(Movimiento $movimiento)
    {
        $dependencia_usuaria_origen_ids=$movimiento->biensMovimientos->pluck('dependencia_usuaria_origen_id');
        if($dependencia_usuaria_origen_ids)
        $this->dataDelOrigen=DependenciaUsuaria::
                leftJoin("unidad_administrativas","unidad_administrativas.id" ,"=", "dependencia_usuarias.unidad_administrativa_id")
                ->leftJoin("subcoordinacions","subcoordinacions.id" ,"=", "unidad_administrativas.subcoordinacion_id")
                ->leftJoin("coordinacions","coordinacions.id" ,"=", "subcoordinacions.coordinacion_id")
                ->whereIn('dependencia_usuarias.id',$dependencia_usuaria_origen_ids)
                ->select([
                    'dependencia_usuarias.id as dependencia_usuaria_origen_id',
                    'dependencia_usuarias.nombre as dependencia_usuaria_origen_nombre',
                    'unidad_administrativas.nombre as unidad_administrativa_origen_nombre',
                    'subcoordinacions.nombre as subcoordinacion_origen_nombre',
                    'coordinacions.nombre as coordinacion_origen_nombre',
                    ])
                ->get();
        $movimiento->biensMovimientos->each(function($x){
            $x->bien->denominacion;
            $x->bien->marca;
            $x->dependenciaUsuaria;
            $x->dependenciaUsuaria->unidadAdministrativa;
            $x->dependenciaUsuaria->unidadAdministrativa->subcoordinacion;
            if($x->dependencia_usuaria_origen_id)
            for ($i=0; $i <count($this->dataDelOrigen) ; $i++) {
                if($x->dependencia_usuaria_origen_id==$this->dataDelOrigen[$i]->dependencia_usuaria_origen_id){
                    $x->dependenciaUsuaria->dependencia_usuaria_origen_nombre=$this->dataDelOrigen[$i]->dependencia_usuaria_origen_nombre;
                    $x->dependenciaUsuaria->unidadAdministrativa->unidad_administrativa_origen_nombre=$this->dataDelOrigen[$i]->unidad_administrativa_origen_nombre;
                    $x->dependenciaUsuaria->unidadAdministrativa->subcoordinacion->subcoordinacion_origen_nombre=$this->dataDelOrigen[$i]->subcoordinacion_origen_nombre;
                }
            }
        });
        $movimiento->detalleTipoMovimiento;
        $movimiento->detalleTipoMovimiento->tipoMovimiento;
        return [
            'movimiento'=>$movimiento,
            //'detalleTipoMovimiento'=>$movimiento->detalleTipoMovimiento,
            //'tipoMovimiento'=>$movimiento->detalleTipoMovimiento->tipoMovimiento,
            //'biensMovimientos'=>$movimiento->biensMovimientos
        ];
    }
}
