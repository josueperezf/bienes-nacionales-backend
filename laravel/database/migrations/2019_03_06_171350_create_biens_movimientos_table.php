<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBiensMovimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('biens_movimientos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('bien_id')->unsigned();
            $table->integer('movimiento_id')->unsigned();
            $table->integer('dependencia_usuaria_id')->unsigned();
            $table->integer('dependencia_usuaria_origen_id')->unsigned();
            $table->integer('actual')->default(1);
            $table->foreign('bien_id')->references('id')->on('biens')->onDelete('cascade');
            $table->foreign('movimiento_id')->references('id')->on('movimientos')->onDelete('cascade');
            $table->foreign('dependencia_usuaria_id')->references('id')->on('dependencia_usuarias')->onDelete('cascade');
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
        Schema::dropIfExists('biens_movimientos');
    }
}
