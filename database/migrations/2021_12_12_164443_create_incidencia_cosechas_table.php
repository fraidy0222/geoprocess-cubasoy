<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncidenciaCosechasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incidencia_cosechas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('ueb_id')->nullable();
            $table->unsignedBigInteger('cultivo_id')->nullable();
            $table->unsignedBigInteger('cosecha_id')->nullable();
            $table->string('cc');
            $table->float('area_total');
            $table->float('a_c_diario');
            $table->float('a_c_acum')->nullable();
            $table->float('a_c_pendiente')->nullable();
            $table->float('t_diario')->nullable();
            $table->float('t_acum');
            $table->float('t_rend');
            $table->float('rend_acum');
            $table->float('arranque_m');
            $table->integer('cant_equipos')->nullable();
            $table->timestamps();

            $table->foreign('ueb_id')->references('id')->on('uebs')->onDelete('cascade');
            $table->foreign('cultivo_id')->references('id')->on('cultivos')->onDelete('cascade');
            $table->foreign('cosecha_id')->references('id')->on('cosechas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('incidencia_cosechas');
    }
}
