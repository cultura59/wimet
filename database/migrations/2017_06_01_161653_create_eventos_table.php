<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('eventos')) {
            Schema::create('eventos', function (Blueprint $table) {
                $table->increments('id');
                $table->string('nombre_evento')->nullable();
                $table->string('titulo_cliente')->nullable();
                $table->enum('lead', array('wimet'))->default('wimet');
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
                $table->integer('total_horas');
                $table->text('descripcion_consulta')->nullable();
                $table->text('notas')->nullable();
                $table->enum('estado', 
                            array(
                                'consulta', 
                                'seguimiento', 
                                'visita', 
                                'presupuesto', 
                                'reservado',
                                'realizado',
                                'perdido'
                            )
                        )->default('consulta');
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
        Schema::dropIfExists('eventos');
    }
}