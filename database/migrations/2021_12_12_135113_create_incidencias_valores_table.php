<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncidenciasValoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incidencias_valores', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('cultivo_id')->nullable();
            $table->unsignedBigInteger('valore_id')->nullable();
            $table->float('venta_diaria_cup');
            $table->float('venta_mes_cup', 8, 2)->nullable(0);
            $table->float('acumulado', 8, 2)->nullable();
            $table->timestamps();

            $table->foreign('cultivo_id')->references('id')->on('cultivos')->onDelete('cascade');
            $table->foreign('valore_id')->references('id')->on('valores')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('incidencias_valores');
    }
}
