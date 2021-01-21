<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DetalleTipoMovimiento;
class DetalleTipoMovimientoController extends Controller
{
    public function porTipoMovimiento($tipo_movimiento_id)
    {
        return DetalleTipoMovimiento::where('tipo_movimiento_id','=',$tipo_movimiento_id)->get();
    }

}