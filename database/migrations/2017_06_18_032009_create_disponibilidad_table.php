<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDisponibilidadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('disponibilidad')) {
            Schema::create('disponibilidad', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('espacio_id')->unsigned();
                $table->foreign('espacio_id')->references('id')->on('espacios');
                $table->enum('dia', array('lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo'));
                $table->string('inicio');
                $table->string('fin');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('disponibilidads');
    }
}
