<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDependenciaUsuariasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dependencia_usuarias', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tipo_dependencia_usuaria_id')->unsigned();
            $table->integer('unidad_administrativa_id')->unsigned();
            $table->string('nombre',100);
            $table->foreign('tipo_dependencia_usuaria_id')->references('id')->on('tipo_dependencia_usuarias')->onDelete('cascade');
            $table->foreign('unidad_administrativa_id')->references('id')->on('unidad_administrativas')->onDelete('cascade');
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
        Schema::dropIfExists('dependencia_usuarias');
    }
}
