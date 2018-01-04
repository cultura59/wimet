<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropuestaServiciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('propuesta_servicios', function (Blueprint $table) {
            $table->integer('propuesta_id')->unsigned()->nullable();
            $table->foreign('propuesta_id')->references('id')
                ->on('propuestas')->onDelete('cascade');
            $table->string('sdescripcion', 255);
            $table->double('simporte', 15, 2);
            $table->integer('scantidad');
            $table->double('stotal', 15, 2);
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
        Schema::dropIfExists('propuesta_servicios');
    }
}
