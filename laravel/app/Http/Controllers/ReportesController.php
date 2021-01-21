<?php

namespace App\Http\Controllers;
use App\Bien;
use App\BiensMovimiento;
use App\DependenciaUsuaria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
class ReportesController extends Controller
{
    public $auxiliar=4;
    public function inventario(Request $request){
        $inventarioActual=[];
        if(empty($request->dependencia_usuaria_id)){
            return  Response::json(['errors'=>['dependencia_usuaria_id'=>['La Dependencia es requerida']]], 422);
        }
        $dependenciaUsuaria=DependenciaUsuaria::find($request->dependencia_usuaria_id);
        $dependenciaUsuaria->unidadAdministrativa;
        $dependenciaUsuaria->unidadAdministrativa->subcoordinacion;
        $inventarioActual=BiensMovimiento
                                ::where('dependencia_usuaria_id','=',$request->dependencia_usuaria_id)
                                ->where('actual','=',2)
                                ->get()->pluck('bien_id','bien_id');
        
        if(!empty($request->fecha))
        if($request->fecha!=date('Y-m-d'))
        {
            //sino trae fecha busco todos los movimientos q se han hecho en esa dependencia desde esa fech hasta la actualidad y los deahogo en un vector
            //movimientos desde la fecha pasada como parametro hasta la actualidad
            $this->auxiliar=$request->dependencia_usuaria_id;
            $movimientos=BiensMovimiento
                                ::leftJoin("movimientos","movimientos.id" ,"=", "biens_movimientos.movimiento_id")
                                //la siguiente linea es equilante a decir esto en sql
                                //(`dependencia_usuaria_id` = 4 or `dependencia_usuaria_origen_id` = 4  )
                                ->where(function($referencia){
                                    //error_log($this->auxiliar );
                                    $referencia->orwhere('dependencia_usuaria_id','=',$this->auxiliar );
                                    $referencia->orwhere('dependencia_usuaria_origen_id','=',$this->auxiliar );
                                })
                                //->orwhere('dependencia_usuaria_id','=',$request->dependencia_usuaria_id)
                                //->orwhere('dependencia_usuaria_origen_id','=',$request->dependencia_usuaria_id)
                                //->where('actual','=',1)
                                ->where('fecha','>=',$request->fecha)
                                //->where('fecha','<',date('Y-m-d'))
                                ->orderBy('biens_movimientos.id','desc')
                                ->select([
                                    'biens_movimientos.bien_id',
                                    'biens_movimientos.id',
                                    'movimiento_id',
                                    'fecha',
                                    'dependencia_usuaria_id',
                                    'dependencia_usuaria_origen_id'])->get();

            //return $movimientos;
            foreach ($movimientos as $movimiento) {
                if($movimiento['dependencia_usuaria_id'] == $request->dependencia_usuaria_id){
                    unset($inventarioActual[$movimiento['bien_id']]);
                    //error_log('eliminar');
                }
                if($movimiento['dependencia_usuaria_origen_id']==$request->dependencia_usuaria_id){
                    //error_log('insertar');
                    $inventarioActual[$movimiento['bien_id']]=$movimiento['bien_id'];
                }
            }
        }
        //return $inventarioActual;
        $inventario=Bien::
                        //leftJoin("dependencia_usuarias","dependencia_usuarias.id" ,"=", "biens_movimientos.dependencia_usuaria_id")
                        leftJoin("marcas","marcas.id" ,"=", "biens.marca_id")
                        ->leftJoin("denominacions","denominacions.id" ,"=", "biens.denominacion_id")
                        //->where('dependencia_usuarias.id','=',$request->dependencia_usuaria_id )
                        ->whereIn('biens.id',$inventarioActual)
                        ->select([
                            'biens.*',
                            'marcas.nombre as marca_nombre',
                            'marcas.id as marca_id',
                            'denominacions.nombre as denominacion_nombre',
                            'denominacions.id as denominacion_id',
                            ])->get();
        return [
            'dependenciaUsuaria'=>$dependenciaUsuaria,
            'biens'        =>$inventario
        ];
        /**/
    }
}
