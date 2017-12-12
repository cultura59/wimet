
<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEspacioServicioPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('espacio_servicio')) {
            Schema::create('espacio_servicio', function (Blueprint $table) {
                $table->integer('espacio_id')->unsigned()->index();
                $table->foreign('espacio_id')->references('id')->on('espacios')->onDelete('cascade');
                $table->integer('servicio_id')->unsigned()->index();
                $table->foreign('servicio_id')->references('id')->on('servicios')->onDelete('cascade');
                $table->primary(['espacio_id', 'servicio_id']);
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
        Schema::dropIfExists('espacio_servicio');
    }
}
