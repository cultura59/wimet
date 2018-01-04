<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropuestaPagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('propuesta_pagos', function (Blueprint $table) {
            $table->integer('propuesta_id')->unsigned()->nullable();
            $table->foreign('propuesta_id')->references('id')
                ->on('propuestas')->onDelete('cascade');
            $table->string('pdescripcion', 255);
            $table->double('ptotal', 15, 2);
            $table->date('pvencimiento');
            $table->enum('pestado', array('Pendiente', 'Aprobada', 'Cancelada'))->default('Pendiente');
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
        Schema::dropIfExists('propuesta_pagos');
    }
}
