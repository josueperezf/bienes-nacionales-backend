<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetalleTipoMovimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_tipo_movimientos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tipo_movimiento_id')->unsigned();
            $table->string('codigo',3);
            $table->string('nombre',250);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalle_tipo_movimientos');
    }
}
