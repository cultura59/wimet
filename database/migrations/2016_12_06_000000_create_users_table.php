<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('users')) {
          Schema::create('users', function (Blueprint $table) {
              $table->increments('id');
              $table->string('firstname');
              $table->string('lastname');
              $table->string('email')->unique();
              $table->string('phone')->nullable();
              $table->string('password');
              $table->string('imagesource')->nullable();
              $table->string('businessName')->nullable();
              $table->string('industry')->nullable();
              $table->text('personaldescription')->nullable();
              $table->string('city')->nullable();
              $table->string('urlfacebook')->nullable();
              $table->string('urllinkedin')->nullable();
              $table->text('databank')->nullable();
              $table->integer('tipo_clientes_id')->unsigned()->default(1);
              $table->foreign('tipo_clientes_id')->references('id')->on('tipo_clientes');
              $table->boolean('isAdmin')->default(false);
              $table->boolean('status')->default(false);
              $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
