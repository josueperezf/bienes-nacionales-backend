<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Coordinacion;
use App\UnidadAdministrativa;
use Illuminate\Support\Facades\DB;
class Subcoordinacion extends Model
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
                         ->where('id','!=',1)
                         //->orWhere('nombre', 'LIKE', "%$buscar%")
                         //->orWhere('direccion', 'LIKE', "%$buscar%")
                         ->Where(DB::raw("
                                CONCAT(ciudad,' ', nombre,' ',direccion,' ',CASE
                                WHEN(subcoordinacions.deleted_at is null )THEN 'ACTIVO'
                                WHEN(subcoordinacions.deleted_at is not null)THEN 'INACTIVO'
                            END )"),'like',"%$buscar%"
                            )
                        ->select('subcoordinacions.*',
                            DB::raw("(CASE
                                WHEN(subcoordinacions.deleted_at is null)THEN 'ACTIVO'
                                WHEN(subcoordinacions.deleted_at is not null)THEN 'INACTIVO'
                            END) as estatus")
                    )
                         ->orderBy($sort,$order)->paginate($pageSize);
        }else{
            return $query
                         ->where('id','!=',1)
                         ->Where(DB::raw("
                                CONCAT(ciudad,' ', nombre,' ',direccion,' ',CASE
                                WHEN(subcoordinacions.deleted_at is null )THEN 'ACTIVO'
                                WHEN(subcoordinacions.deleted_at is not null)THEN 'INACTIVO'
                            END )"),'like',"%$buscar%"
                            )
                         ->orderBy($sort,$order)->paginate($pageSize);
        }
    }
    public function coordinacion()
    {
    	return $this->belongsTo(Coordinacion::class);
    }
    public function unidadAdministrativas()
    {
    	return $this->hasMany(UnidadAdministrativa::class);
    }
}