<?php

namespace App;
use App\UnidadAdministrativa;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
class DependenciaUsuaria extends Model
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
                         ->leftJoin("unidad_administrativas","unidad_administrativas.id" ,"=", "dependencia_usuarias.unidad_administrativa_id")
                         ->leftJoin("tipo_dependencia_usuarias","tipo_dependencia_usuarias.id" ,"=", "dependencia_usuarias.tipo_dependencia_usuaria_id")
                         ->where('dependencia_usuarias.id','like','%'.$buscar.'%')
                         ->orWhere('dependencia_usuarias.nombre', 'LIKE', "%$buscar%")
                         ->orWhere('tipo_dependencia_usuarias.nombre', 'LIKE', "%$buscar%")
                         ->orWhere('unidad_administrativas.nombre', 'LIKE', "%$buscar%")
                         ->orWhere(DB::raw("
                               CONCAT(CASE
                                WHEN(dependencia_usuarias.deleted_at is null )THEN 'ACTIVO'
                                WHEN(dependencia_usuarias.deleted_at is not null)THEN 'INACTIVO'
                            END )"),'like',"%$buscar%"
                            )
                         ->select([
                             'dependencia_usuarias.*',
                             'unidad_administrativas.nombre as unidad_administrativa_nombre',
                             'tipo_dependencia_usuarias.nombre as tipo_dependencia_usuaria_nombre',
                             DB::raw("(CASE
                                WHEN(dependencia_usuarias.deleted_at is null)THEN 'ACTIVO'
                                WHEN(dependencia_usuarias.deleted_at is not null)THEN 'INACTIVO'
                            END) as estatus")
                             ])
                         ->orderBy($sort,$order)->paginate($pageSize);
        }else{
            return $query->leftJoin("unidad_administrativas","unidad_administrativas.id" ,"=", "dependencia_usuarias.unidad_administrativa_id")
                         ->leftJoin("tipo_dependencia_usuarias","tipo_dependencia_usuarias.id" ,"=", "dependencia_usuarias.tipo_dependencia_usuaria_id")
                         ->where('dependencia_usuarias.id','like','%'.$buscar.'%')
                         ->orWhere('dependencia_usuarias.nombre', 'LIKE', "%$buscar%")
                         ->orWhere('tipo_dependencia_usuarias.nombre', 'LIKE', "%$buscar%")
                         ->orWhere('unidad_administrativas.nombre', 'LIKE', "%$buscar%")
                         ->orWhere(DB::raw("
                               CONCAT(CASE
                                WHEN(dependencia_usuarias.deleted_at is null )THEN 'ACTIVO'
                                WHEN(dependencia_usuarias.deleted_at is not null)THEN 'INACTIVO'
                            END )"),'like',"%$buscar%"
                            )
                         ->select([
                             'dependencia_usuarias.*',
                             'unidad_administrativas.nombre as unidad_administrativa_nombre',
                             'tipo_dependencia_usuarias.nombre as tipo_dependencia_usuaria_nombre',
                             DB::raw("(CASE
                                WHEN(dependencia_usuarias.deleted_at is null)THEN 'ACTIVO'
                                WHEN(dependencia_usuarias.deleted_at is not null)THEN 'INACTIVO'
                            END) as estatus")
                             ])
                         ->orderBy($sort,$order)->paginate($pageSize);
        }
    }
    public function unidadAdministrativa()
    {
    	return $this->belongsTo(UnidadAdministrativa::class);
    }
}