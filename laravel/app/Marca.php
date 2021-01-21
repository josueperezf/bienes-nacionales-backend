<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use App\Bien;
class Marca extends Model
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
                         ->where('id','like','%'.$buscar.'%')
                         ->orWhere('nombre', 'LIKE', "%$buscar%")
                         ->orWhere(DB::raw("
                                CONCAT(CASE
                                WHEN(marcas.deleted_at is null )THEN 'ACTIVO'
                                WHEN(marcas.deleted_at is not null)THEN 'INACTIVO'
                            END )"),'like',"%$buscar%"
                            )
                        ->select('marcas.*',
                            DB::raw("(CASE
                                WHEN(marcas.deleted_at is null)THEN 'ACTIVO'
                                WHEN(marcas.deleted_at is not null)THEN 'INACTIVO'
                            END) as estatus")
                    )
                         ->orderBy($sort,$order)->paginate($pageSize);
        }else{
            return $query
                         ->where('id','like','%'.$buscar.'%')
                         ->orWhere('nombre', 'LIKE', "%$buscar%")
                         ->orderBy($sort,$order)->paginate($pageSize);
        }
    }
    public function biens(){
        return $this->hasMany(Bien::class);
    }
}
