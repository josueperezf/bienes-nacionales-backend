<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnidadAdministrativasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unidad_administrativas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('subcoordinacion_id')->unsigned();
            $table->string('nombre',100);
            $table->string('telefono',12);
            $table->foreign('subcoordinacion_id')->references('id')->on('subcoordinacions')->onDelete('cascade');
            $table->softDeletes();
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
        Schema::dropIfExists('unidad_administrativas');
    }
}
