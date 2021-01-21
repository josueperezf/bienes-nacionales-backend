<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubcoordinacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subcoordinacions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('coordinacion_id')->unsigned();
            $table->string('ciudad',100);
            $table->string('nombre',100)->unique();
            $table->string('direccion',100);
            //$table->primary('id');
            $table->foreign('coordinacion_id')->references('id')->on('coordinacions')->onDelete('cascade');
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
        Schema::dropIfExists('subcoordinacions');
    }
}
