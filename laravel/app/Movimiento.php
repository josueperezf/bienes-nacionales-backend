<?php

namespace App;
use App\DetalleTipoMovimiento;
use App\BiensMovimiento;
use Illuminate\Database\Eloquent\Model;
class Movimiento extends Model
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
                ->leftJoin("detalle_tipo_movimientos","detalle_tipo_movimientos.id" ,"=", "movimientos.detalle_tipo_movimiento_id")
                ->leftJoin("tipo_movimientos","tipo_movimientos.id" ,"=", "detalle_tipo_movimientos.tipo_movimiento_id")
                ->where('movimientos.id','like','%'.$buscar.'%')
                ->orWhere('movimientos.fecha', 'LIKE', "%$buscar%")
                ->orWhere('detalle_tipo_movimientos.nombre', 'LIKE', "%$buscar%")
                ->orWhere('tipo_movimientos.nombre', 'LIKE', "%$buscar%")
                ->select([
                    'movimientos.*',
                    'detalle_tipo_movimientos.nombre as detalle_tipo_movimiento_nombre',
                    'tipo_movimientos.nombre as tipo_movimiento_nombre',
                    ])
                ->orderBy($sort,$order)->paginate($pageSize);
    }
    public function detalleTipoMovimiento(){
        return $this->belongsTo(DetalleTipoMovimiento::class);
    }
    public function biensMovimientos(){
        return $this->hasMany(BiensMovimiento::class);
    }
}
//BiensMovimiento