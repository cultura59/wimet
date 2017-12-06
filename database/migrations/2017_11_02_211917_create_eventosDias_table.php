<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventosDiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('eventos_dias')) {
            Schema::create('eventos_dias', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('evento_id')->unsigned()->index();
                $table->foreign('evento_id')->references('id')->on('eventos')->onDelete('cascade');
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
        Schema::dropIfExists('eventos_dias');
    }
}
