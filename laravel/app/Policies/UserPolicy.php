<?php

namespace App\Policies;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    public function adminOPropietarioDeCuenta(User $userSessionActual, $UserParametro)
    {
        $respuesta=false;
        if($userSessionActual->rol_id==1){
            $respuesta=true;
        }else{
            if($userSessionActual->id==$UserParametro->id){
                $respuesta=true;
            }
        }
        return $respuesta;
    }
}
