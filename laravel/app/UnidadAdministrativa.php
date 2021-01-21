<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Subcoordinacion;
use App\DependenciaUsuaria;
use Illuminate\Support\Facades\DB;
class UnidadAdministrativa extends Model
{
    use SoftDeletes;
    protected $guarded=['id'];
    protected $dates=['deleted_at'];
    public function scopeBuscador($query,$parametros=[])
    {
        $todos=false;
        (!empty($parametros['buscar']))? $buscar=$parametros['buscar'] : $buscar='';
        (!empty($parametros['sort']))? $sort=$parametros['sort'] : $sort='id';
        (!empty($parametros['order']))? $order=$parametros['order'] : $order='';
        (!empty($parametros['pageSize'])) ? $pageSize=''.$parametros['pageSize'] : $pageSize ='100000000000';
        if(!empty($parametros['todos'])) $todos=true;
        if($todos){
            return $query
                         ->withTrashed()
                         ->leftJoin("subcoordinacions","subcoordinacions.id" ,"=", "unidad_administrativas.subcoordinacion_id")
                         ->where('subcoordinacions.id','!=',1)
                         //->orWhere('telefono', 'LIKE', "%$buscar%")
                         //->orWhere('unidad_administrativas.nombre', 'LIKE', "%$buscar%")
                         //->orWhere('subcoordinacions.nombre', 'LIKE', "%$buscar%")
                         ->Where(DB::raw("
                                CONCAT(
                                    subcoordinacions.nombre,' ',
                                    unidad_administrativas.nombre, ' ',
                                    unidad_administrativas.telefono, ' ',
                                    CASE
                                WHEN(unidad_administrativas.deleted_at is null )THEN 'ACTIVO'
                                WHEN(unidad_administrativas.deleted_at is not null)THEN 'INACTIVO'
                            END )"),'like',"%$buscar%"
                            )
                         ->select([
                             'unidad_administrativas.*',
                             'subcoordinacions.nombre as subcoordinacion_nombre',
                             DB::raw("(CASE
                                WHEN(unidad_administrativas.deleted_at is null)THEN 'ACTIVO'
                                WHEN(unidad_administrativas.deleted_at is not null)THEN 'INACTIVO'
                            END) as estatus")
                             ])
                         ->orderBy($sort,$order)->paginate($pageSize);
        }else{
            return $query->leftJoin("subcoordinacions","subcoordinacions.id" ,"=", "unidad_administrativas.subcoordinacion_id")
                         ->where('subcoordinacions.id','like','%'.$buscar.'%')
                         ->orWhere('telefono', 'LIKE', "%$buscar%")
                         ->orWhere('unidad_administrativas.nombre', 'LIKE', "%$buscar%")
                         ->orWhere('subcoordinacions.nombre', 'LIKE', "%$buscar%")
                         ->orWhere(DB::raw("
                                CONCAT(CASE
                                WHEN(unidad_administrativas.deleted_at is null )THEN 'ACTIVO'
                                WHEN(unidad_administrativas.deleted_at is not null)THEN 'INACTIVO'
                            END )"),'like',"%$buscar%"
                            )
                         ->select([
                             'unidad_administrativas.*',
                             'subcoordinacions.nombre as subcoordinacion_nombre',
                             DB::raw("(CASE
                                WHEN(unidad_administrativas.deleted_at is null)THEN 'ACTIVO'
                                WHEN(unidad_administrativas.deleted_at is not null)THEN 'INACTIVO'
                            END) as estatus")
                             ])
                         ->orderBy($sort,$order)->paginate($pageSize);
        }
    }
    public function subcoordinacion()
    {
    	return $this->belongsTo(Subcoordinacion::class);
    }
    public function dependenciaUsuarias()
    {
    	return $this->hasMany(DependenciaUsuaria::class);
    }
}