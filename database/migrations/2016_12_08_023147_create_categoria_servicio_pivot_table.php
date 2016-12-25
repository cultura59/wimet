<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriaServicioPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categoria_servicio', function (Blueprint $table) {
            $table->integer('categoria_id')->unsigned()->index();
            $table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('cascade');
            $table->integer('servicio_id')->unsigned()->index();
            $table->foreign('servicio_id')->references('id')->on('servicios')->onDelete('cascade');
            $table->primary(['categoria_id', 'servicio_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('categoria_servicio');
    }
}
