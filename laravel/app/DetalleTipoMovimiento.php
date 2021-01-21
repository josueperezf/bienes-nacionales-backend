<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\TipoMovimiento;
class DetalleTipoMovimiento extends Model
{
    public function tipoMovimiento(){
        return $this->belongsTo(TipoMovimiento::class);
    }
}
