<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCharacteristicEspacioPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('characteristics_espacio')) {
            Schema::create('characteristics_espacio', function (Blueprint $table) {
                $table->integer('characteristics_id')->unsigned()->index();
                $table->foreign('characteristics_id')->references('id')->on('characteristics')->onDelete('cascade');
                $table->integer('espacio_id')->unsigned()->index();
                $table->foreign('espacio_id')->references('id')->on('espacios')->onDelete('cascade');
                $table->primary(['characteristics_id', 'espacio_id']);
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
        Schema::dropIfExists('characteristics_espacio');
    }
}
