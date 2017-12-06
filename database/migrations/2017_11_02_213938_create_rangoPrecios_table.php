<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRangoPreciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('rango_precios')) {
            Schema::create('rango_precios', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('price_id')->unsigned();
                $table->foreign('price_id')->references('id')->on('prices')->onDelete('cascade');
                $table->integer('desde');
                $table->integer('hasta');
                $table->double('precio', 15, 8);
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
        Schema::dropIfExists('rango_precios');
    }
}
