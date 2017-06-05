<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropuestasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('propuestas')) {
            Schema::create('propuestas', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('evento_id')->unsigned();
                $table->foreign('evento_id')->references('id')->on('eventos');
                $table->integer('estilo_espacios_id')->unsigned();
                $table->foreign('estilo_espacios_id')->references('id')->on('estilo_espacios');
                $table->integer('invitados');
                $table->timestamp('reserva_desde')->default(\Carbon\Carbon::now()->toDateTimeString());
                $table->timestamp('reserva_hasta')->default(\Carbon\Carbon::now()->toDateTimeString());
                $table->integer('user_id')->unsigned();
                $table->foreign('user_id')->references('id')->on('users');
                $table->integer('cliente_id')->unsigned();
                $table->foreign('cliente_id')->references('id')->on('users');
                $table->integer('espacio_id')->unsigned();
                $table->foreign('espacio_id')->references('id')->on('espacios');
                $table->double('sub_total', 15, 2);
                $table->double('tu_pago', 15, 2);
                $table->double('comision', 15, 2);
                $table->timestamp('vencimiento_propuesta')->default(\Carbon\Carbon::now()->toDateTimeString());
                $table->double('deposito', 15, 2);
                $table->enum('cancellationflexibility', array('flexible', 'moderado', 'estricto'))->nullable();
                $table->string('codigo')->nullable();
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
        Schema::dropIfExists('propuestas');
    }
}
