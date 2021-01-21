<?php
namespace App\Http\Controllers;
use App\Marca;
use App\Bien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Http\Requests\RequestMarcaCreate;
use App\Http\Requests\RequestMarcaUpdate;

class MarcaController extends Controller
{
    public function index(Request $request)
    {
        return Marca::Buscador($request->all());
    }

    public function store(RequestMarcaCreate $request)
    {
        $marca= new Marca($request->all());
        $marca->save();
        return Response::json(['message'=>'Operacion Exitosa'],201);
    }
    public function show(Marca $marca)
    {
        $biens=Bien::join('denominacions','denominacions.id','=','biens.denominacion_id')
            ->join("biens_movimientos",function($join){
                $join->on("biens_movimientos.bien_id" ,"=", "biens.id");
                $join->where('biens_movimientos.actual','=',2);
            })
            ->leftJoin("dependencia_usuarias","dependencia_usuarias.id" ,"=", "biens_movimientos.dependencia_usuaria_id")
            ->where('biens.marca_id','=',$marca->id)
            ->select([
                'biens.*',
                'denominacions.id as denominacion_id',
                'denominacions.nombre as denominacion_nombre',
                'dependencia_usuarias.nombre as dependencia_usuaria_nombre',
                'dependencia_usuarias.id as dependencia_usuaria_id'])
            ->get();
        return [
            'marca'=>$marca,
            'biens'=>$biens
        ];
    }
    public function update(RequestMarcaUpdate $request,  $id)
    {
        $marca=Marca::withTrashed()->where('id','=',$id)->first();
        if(($request->deleted_at==null) and  ($marca->deleted_at!=null))
            $marca->restore();
        else
            $marca->fill($request->all())->update();
        return Response::json(['mensaje'=>'Operacion Exitosa'],200);
    }
    public function destroy(Marca $marca)
    {
        $marca->delete();
        return Response::json(['message'=>'Eliminacion Exitosa'],200);
    }
}