<?php

namespace App\Http\Controllers;
use App\Http\Requests\RequestPersonaCreate;
use App\Http\Requests\RequestPersonaUpdate;
use App\Persona;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
class PersonaController extends Controller
{
    public function index(Request $request)
    {
        $buscar='';
        $pageSize=1;
        if($request->pageSize)
        $pageSize=$request->pageSize;
        /*
        if($request->nombre)
        $nombre=$request->nombre;
        if($request->buscar)
        $buscar=$request->buscar;
        //dd($pageSize);*/
        $personas=Persona::Buscador($buscar,$request->sort,$request->order)->paginate($pageSize);
        return $personas;
    }
    public function store(RequestPersonaCreate $request)
    {
        $persona= new Persona($request->all());
        $persona->save();
        return Response::json(['message'=>'Operacion Exitosa'],201);
    }
    public function show($id)
    {
        $persona= Persona::find($id);
        return Response::json($persona,201);
    }
    public function update(RequestPersonaUpdate $request, $id)
    {
        $persona=Persona::find($id);
        $persona->fill($request->all())->update();
        return Response::json(['message'=>'Operacion Exitosa'],200);
    }
    public function destroy($id)
    {
        $persona=Persona::find($id);
        $persona->delete();
        return Response::json(['message'=>'Eliminacion Exitosa'],200);

    }
}