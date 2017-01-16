<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEspacioTagPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('espacio_tag')) {
            Schema::create('espacio_tag', function (Blueprint $table) {
                $table->integer('espacio_id')->unsigned()->index();
                $table->foreign('espacio_id')->references('id')->on('espacios')->onDelete('cascade');
                $table->integer('tag_id')->unsigned()->index();
                $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
                $table->primary(['espacio_id', 'tag_id']);
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
        Schema::dropIfExists('espacio_tag');
    }
}
