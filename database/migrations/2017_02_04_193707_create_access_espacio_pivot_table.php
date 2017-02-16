<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccessEspacioPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('access_espacio', function (Blueprint $table) {
            $table->integer('access_id')->unsigned()->index();
            $table->foreign('access_id')->references('id')->on('accesses')->onDelete('cascade');
            $table->integer('espacio_id')->unsigned()->index();
            $table->foreign('espacio_id')->references('id')->on('espacios')->onDelete('cascade');
            $table->primary(['access_id', 'espacio_id']);
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
        Schema::drop('access_espacio');
    }
}
