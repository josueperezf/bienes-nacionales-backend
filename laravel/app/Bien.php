<?php

namespace App;
use App\Marca;
use App\Denominacion;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Bien extends Model
{
    protected $guarded=['id'];
    public function scopeBuscador($query,$parametros=[])
    {
        $todos=false;
        (!empty($parametros['buscar']))? $buscar=$parametros['buscar'] : $buscar='';
        (!empty($parametros['sort']))? $sort=$parametros['sort'] : $sort='id';
        (!empty($parametros['order']))? $order=$parametros['order'] : $order='';
        (!empty($parametros['pageSize'])) ? $pageSize=''.$parametros['pageSize'] : $pageSize ='100000000000';
        if(!empty($parametros['todos'])) $todos=true;
        return $query
                //->leftJoin("biens_movimientos","biens_movimientos.bien_id" ,"=", "biens.id")
                ->join("biens_movimientos",function($join){
                    $join->on("biens_movimientos.bien_id" ,"=", "biens.id");
                    $join->where('biens_movimientos.actual','=',2);
                })
                ->leftJoin("dependencia_usuarias","dependencia_usuarias.id" ,"=", "biens_movimientos.dependencia_usuaria_id")
                ->leftJoin("marcas","marcas.id" ,"=", "biens.marca_id")
                ->leftJoin("denominacions","denominacions.id" ,"=", "biens.denominacion_id")
                ->where('biens_movimientos.actual','=',2)
                ->where('biens.id','like','%'.$buscar.'%')
                ->orWhere('marcas.nombre', 'LIKE', "%$buscar%")
                ->orWhere('denominacions.nombre', 'LIKE', "%$buscar%")
                ->orWhere('dependencia_usuarias.nombre', 'LIKE', "%$buscar%")
                ->orWhere('biens.codigo', 'LIKE', "%$buscar%")
                ->orWhere('biens.serial', 'LIKE', "%$buscar%")
                ->select([
                    'biens.*',
                    'marcas.nombre as marca_nombre',
                    'marcas.id as marca_id',
                    'denominacions.nombre as denominacion_nombre',
                    'denominacions.id as denominacion_id',
                    'dependencia_usuarias.nombre as dependencia_usuaria_nombre',
                    'dependencia_usuarias.id as dependencia_usuaria_id',
                    ])
                ->orderBy($sort,$order)->paginate($pageSize);
    }
    public function denominacion(){
        return $this->belongsTo(Denominacion::class);
    }
    public function marca(){
        return $this->belongsTo(Marca::class);
    }
}
