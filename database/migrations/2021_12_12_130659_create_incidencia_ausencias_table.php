<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncidenciaAusenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incidencia_ausencias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('ueb_id')->nullable();
            $table->unsignedBigInteger('ausencia_id')->nullable();
            $table->integer('certificados_medicos');
            $table->integer('lic_maternidad');
            $table->integer('vacaciones');
            $table->integer('aus_autorizadas');
            $table->integer('aus_injustificadas');
            $table->integer('otras');
            $table->integer('aislados');
            $table->integer('positivos');
            $table->integer('madres_ninnos');
            $table->timestamps();

            $table->foreign('ueb_id')->references('id')->on('uebs')->onDelete('cascade');
            $table->foreign('ausencia_id')->references('id')->on('ausencias')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('incidencia_ausencias');
    }
}
