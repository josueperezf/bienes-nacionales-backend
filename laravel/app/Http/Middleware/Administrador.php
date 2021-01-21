<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Response;
class Administrador
{
    public $auth;
    public function __construct(Guard $auth)
    {
        $this->auth=$auth;
    }

    public function handle($request, Closure $next)
    {
        //$rutaActual=$request->path();
        //dd($this->auth->user()->rol_id);
        if($this->auth->user()->rol_id==1){
            return $next($request);
        }
        else{
            //abort(401);
            return Response::json([
                'message' => 'Usuario no Autorizado',
            ], 403);
            
        }
        
            //return false;
        


            

        
    }
}
