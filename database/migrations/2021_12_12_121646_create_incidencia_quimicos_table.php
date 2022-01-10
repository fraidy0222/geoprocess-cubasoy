<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncidenciaQuimicosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incidencia_quimicos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('ueb_id')->nullable();
            $table->unsignedBigInteger('quimico_id')->nullable();
            $table->integer('cc')->default(0);
            $table->integer('area_aplicada')->default(0);
            $table->integer('area_acum')->default(0);
            $table->string('tipo_aplicacion')->nullable();
            $table->string('tipo_producto')->nullable();
            $table->integer('cant')->default(0);
            $table->string('cant_equipos')->nullable();
            $table->timestamps();

            $table->foreign('ueb_id')->references('id')->on('uebs')->onDelete('cascade');
            $table->foreign('quimico_id')->references('id')->on('quimicos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('incidencia_quimicos');
    }
}
