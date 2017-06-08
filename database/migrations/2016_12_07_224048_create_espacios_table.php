<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEspaciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('espacios')) {
            Schema::create('espacios', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id')->unsigned();
                $table->foreign('user_id')->references('id')->on('users');
                $table->string('name')->unique();
                $table->text('description')->nullable();
                $table->text('rule')->nullable();
                $table->text('politcancel')->nullable();
                $table->integer('quantyrooms')->default(0)->nullable();
                $table->integer('quantybathrooms')->default(0)->nullable();
                $table->integer('floor')->default(0)->nullable();
                $table->integer('surface')->default(0)->nullable();
                $table->integer('quanty')->default(0)->nullable();
                $table->integer('foot')->default(0)->nullable();
                $table->integer('seated')->default(0)->nullable();
                $table->string('adress')->nullable();
                $table->string('city')->nullable();
                $table->string('state')->nullable();
                $table->string('country')->nullable();
                $table->string('long')->nullable();
                $table->string('lat')->nullable();
                $table->double('securitydeposit', 15, 2)->default(0)->nullable();
                $table->enum('cancellationflexibility', array('flexible', 'moderado', 'estricto'))->nullable();
                $table->enum('type', array('comercial', 'privado'))->nullable();
                $table->integer('step')->default(1)->nullable();
                $table->text('image360')->nullable();
                $table->timestamps();
                $table->softDeletes();
                $table->boolean('status')->default(false);
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
        Schema::dropIfExists('espacios');
    }
}
