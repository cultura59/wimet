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
                $table->integer('quantyrooms')->default(0);
                $table->integer('quantybathrooms')->default(0);
                $table->integer('floor')->default(0);
                $table->integer('surface')->default(0);
                $table->integer('quanty')->default(0);
                $table->integer('foot')->default(0);
                $table->integer('seated')->default(0);
                $table->string('adress');
                $table->string('city');
                $table->string('state');
                $table->string('country');
                $table->string('long');
                $table->string('lat');
                $table->double('securitydeposit', 15, 2);
                $table->enum('cancellationflexibility', array('flexible', 'moderado', 'estricto'));
                $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
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
