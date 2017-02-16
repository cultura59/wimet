<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEspacioEstiloEspacioPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('espacio_estilo_espacio', function (Blueprint $table) {
            $table->integer('espacio_id')->unsigned()->index();
            $table->foreign('espacio_id')->references('id')->on('espacios')->onDelete('cascade');
            $table->integer('estilo_espacio_id')->unsigned()->index();
            $table->foreign('estilo_espacio_id')->references('id')->on('estilo_espacios')->onDelete('cascade');
            $table->primary(['espacio_id', 'estilo_espacio_id']);
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
        Schema::drop('espacio_estilo_espacio');
    }
}
