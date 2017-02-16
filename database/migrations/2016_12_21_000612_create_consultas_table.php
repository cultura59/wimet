<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsultasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('consultas')) {
            Schema::create('consultas', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id')->unsigned();
                $table->foreign('user_id')->references('id')->on('users');
                $table->integer('espacio_id')->unsigned();
                $table->foreign('espacio_id')->references('id')->on('espacios');
                $table->timestamp('reserva_desde')->default(\Carbon\Carbon::now()->toDateTimeString());
                $table->timestamp('reserva_hasta')->default(\Carbon\Carbon::now()->toDateTimeString());
                $table->text('consulta');
                $table->enum('estado', array('consulta', 'pendiente', 'rechazado', 'aprobado'));
                $table->integer('reserva_id')->unsigned();
                $table->foreign('reserva_id')->references('id')->on('reservas');
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
        Schema::dropIfExists('consultas');
    }
}
