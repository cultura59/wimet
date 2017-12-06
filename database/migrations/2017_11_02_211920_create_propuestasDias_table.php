<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropuestasDiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('propuestas_dias')) {
            Schema::create('propuestas_dias', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('propuesta_id')->unsigned()->index();
                $table->foreign('propuesta_id')->references('id')->on('propuestas')->onDelete('cascade');
                $table->date('fecha');
                $table->enum('tipo', array('all', 'morning', 'night'));
                $table->timestamps();
                $table->softDeletes();
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
        Schema::dropIfExists('propuestas_dias');
    }
}
