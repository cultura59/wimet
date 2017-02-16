<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEspacioRulePivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('espacio_rules')) {
            Schema::create('espacio_rules', function (Blueprint $table) {
                $table->integer('espacio_id')->unsigned()->index();
                $table->foreign('espacio_id')->references('id')->on('espacios')->onDelete('cascade');
                $table->integer('rules_id')->unsigned()->index();
                $table->foreign('rules_id')->references('id')->on('rules')->onDelete('cascade');
                $table->primary(['espacio_id', 'rules_id']);
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
        Schema::dropIfExists('espacio_rule');
    }
}
