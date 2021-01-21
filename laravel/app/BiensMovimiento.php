<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Bien;
use App\DependenciaUsuaria;
class BiensMovimiento extends Model
{
    protected $guarded=['id'];
    public function bien(){
        return $this->belongsTo(Bien::class);
    }
    public function dependenciaUsuaria(){
        return $this->belongsTo(DependenciaUsuaria::class);
    }
}
