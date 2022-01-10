<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncidenciaEnergiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incidencia_energias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger("ueb_id")->nullable();
            $table->unsignedBigInteger("energia_id")->nullable();
            $table->integer('plan_mes_energia');
            $table->integer('plan_real_energia')->default(0);
            $table->integer('porciento_energia')->default(0);
            $table->integer('plan_mes_petroleo');
            $table->integer('plan_real_petroleo')->default(0);
            $table->integer('porciento_petroleo')->default(0);
            $table->timestamps();

            $table->foreign('ueb_id')->references('id')->on('uebs')->onDelete('cascade');
            $table->foreign('energia_id')->references('id')->on('energias')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('incidencia_energias');
    }
}
