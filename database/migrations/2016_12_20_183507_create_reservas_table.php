<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('reservas')) {
            Schema::create('reservas', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('cliente_id')->unsigned();
                $table->foreign('cliente_id')->references('id')->on('users');
                $table->integer('espacio_id')->unsigned();
                $table->foreign('espacio_id')->references('id')->on('espacios');
                $table->timestamp('reserva_desde')->default(\Carbon\Carbon::now()->toDateTimeString());
                $table->timestamp('reserva_hasta')->default(\Carbon\Carbon::now()->toDateTimeString());
                $table->string('subtotal');
                $table->string('fee');
                $table->string('total');
                $table->string('paymentmethod');
                $table->integer('numbercomprobant');
                $table->boolean('status')->default(false);
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
        Schema::dropIfExists('reservas');
    }
}
