<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('prices')) {
            Schema::create('prices', function (Blueprint $table) {
                $table->increments('id');
                $table->double('price', 15, 8);
                $table->integer('espacio_id')->unsigned();
                $table->foreign('espacio_id')->references('id')->on('espacios')->onDelete('cascade');
                $table->integer('categoria_id')->unsigned();
                $table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('cascade');
                $table->integer('minhours')->default(false);
                $table->boolean('status');
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
        Schema::dropIfExists('prices');
    }
}
