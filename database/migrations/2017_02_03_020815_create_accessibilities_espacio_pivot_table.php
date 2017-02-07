<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccessibilitiesEspacioPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('accessibilities_espacio')) {
            Schema::create('accessibilities_espacio', function (Blueprint $table) {
                $table->integer('accessibilities_id')->unsigned()->index();
                $table->foreign('accessibilities_id')->references('id')->on('accessibilities')->onDelete('cascade');
                $table->integer('espacio_id')->unsigned()->index();
                $table->foreign('espacio_id')->references('id')->on('espacios')->onDelete('cascade');
                $table->primary(['accessibilities_id', 'espacio_id']);
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
        Schema::dropIfExists('accessibilities_espacio');
    }
}
