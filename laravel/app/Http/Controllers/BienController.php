<?php

namespace App\Http\Controllers;

use App\Bien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Denominacion;
use App\Movimiento;
use App\Marca;
use App\Categoria;
use App\DetalleTipoMovimiento;
use App\DependenciaUsuaria;
use App\BiensMovimiento;
use App\Coordinacion;
use App\Http\Requests\RequestBienCreate;
use App\Http\Requests\RequestBienUpdate;
class BienController extends Controller
{
    public function index(Request $request)
    {
        return Bien::Buscador($request->all());
    }
    public function create()
    {
        return [
            'coordinacions'=>Coordinacion::where('id','!=',1)->select('id','nombre')->get(),
            'categorias'=>Categoria::select('id','nombre')->get(),
            'marcas'=>Marca::select('id','nombre')->get(),
            'detalleTipoMovimientos'=>DetalleTipoMovimiento::where('tipo_movimiento_id','=','1')->select('id','nombre')->get()
        ];
    }

    public function store(RequestBienCreate $request)
    {
        //como todo bien debe ser incorporado mediante un movimiento, pues se inserta el bien y de una vez se crea el movimiento o el detalle segun sea el caso
        //si no tiene movimiento_id ni detalle_tipo_movimiento, entonces no puede ser procesada
        if(empty($request->movimiento_id) and empty($request->detalle_tipo_movimiento_id))
        {
            return  Response::json(['errors'=>['detalle_tipo_movimiento_id'=>['No posee los requisitos minimos para crear un bien en el sistema, contacte al programador']]], 422);
        }
        if($request->detalle_tipo_movimiento_id<1 or $request->detalle_tipo_movimiento_id>17)
            return  Response::json(['errors'=>['detalle_tipo_movimiento_id'=>['Detalle de tipo de movimiento invalido para una incorporacion']]], 422);
        //si no viene una depencia usuaria
        if(empty($request->dependencia_usuaria_id)){
            return  Response::json(['errors'=>['dependencia_usuaria_id'=>['Dependencia usuaria es obligatoria']]], 422);
        }else{
            $dependencia_usuaria=DependenciaUsuaria::where('id','=',$request->dependencia_usuaria_id)->where('tipo_dependencia_usuaria_id','=',1)->first();
            if(!$dependencia_usuaria)
            return  Response::json(['errors'=>['dependencia_usuaria_id'=>['Dependencia usuaria Invalida, debe ser tipo almacen o deposito']]], 422);
        }
        //hago esto porque el dolar request tiene mas datos de los q pide el modelo, entonces al hacer es save arrojaria error
        $dataBien=[
            'denominacion_id'=>$request->denominacion_id,
            'marca_id'  =>$request->marca_id,
            'codigo'    =>$request->codigo,
            'serial'    =>$request->serial,
            'monto'     =>$request->monto,
            'descripcion'=>$request->descripcion,
        ];
        $bien=new Bien($dataBien);
        $bien->save();
        if(!empty($request->movimiento_id)){
            //inserto solo en biens_movimientos
            $biensMovimiento= new BiensMovimiento(['actual'=>2, 'movimiento_id'=>$request->movimiento_id,'bien_id'=>$bien->id,'dependencia_usuaria_id'=>$request->dependencia_usuaria_id]);
            $biensMovimiento->save();
            return Response::json(['bien'=>$bien, 'movimiento_id'=>$request->movimiento_id, 'message'=>'Operacion Exitosa'],201);
        }elseif(!empty($request->detalle_tipo_movimiento_id)){
            //inserto en movimientos y luego en biens_movimientos
            //sino tiene fecha le asigno la actual del servidor
            ($request->fecha)? $fecha=$request->fecha:$fecha=date('Y-m-d h:m:s');
            $movimiento= new Movimiento(['fecha'=>$fecha, 'detalle_tipo_movimiento_id'=>$request->detalle_tipo_movimiento_id]);
            $movimiento->save();
            $biensMovimiento= new BiensMovimiento(['actual'=>2, 'movimiento_id'=>$movimiento->id,'bien_id'=>$bien->id,'dependencia_usuaria_id'=>$request->dependencia_usuaria_id]);
            $biensMovimiento->save();
            return Response::json(['bien'=>$bien, 'movimiento_id'=>$movimiento->id, 'message'=>'Operacion Exitosa'],201);            
        }
    }
    public function show(Bien $bien)
    {
        $bien->denominacion;
        $bien->marca;
        $dependencia_usuaria=Bien::join("biens_movimientos",function($join){
            $join->on("biens_movimientos.bien_id" ,"=", "biens.id");
            $join->where('biens_movimientos.actual','=',2);
        })->join('dependencia_usuarias','dependencia_usuarias.id','=','biens_movimientos.dependencia_usuaria_id')
        ->where('biens_movimientos.bien_id','=',$bien->id)
        ->select(['dependencia_usuarias.*'])
            ->first();
        return [
            'bien'=>$bien,
            'dependencia_usuaria'=>$dependencia_usuaria
        ];
    }

    public function edit(Bien $bien)
    {
        return [
            'categorias'=>Categoria::select('id','nombre')->get(),
            'denominacions'=>Denominacion::where('categoria_id','=',$bien->denominacion->categoria_id)->select('id','nombre')->get(),
            'bien'=>$bien,
            'marcas'=>Marca::select('id','nombre')->get(),
        ];
    }


    public function update(RequestBienUpdate $request, Bien $bien)
    {
        $bien->fill($request->all());
        $bien->update();
        return Response::json(['bien'=>$bien, 'message'=>'Operacion Exitosa'],201);
    }

}