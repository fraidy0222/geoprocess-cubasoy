<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnergiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('energias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger("ueb_id")->nullable();
            $table->integer('plan_mes_energia');
            $table->integer('plan_real_energia')->nullable();
            $table->integer('porciento_energia')->nullable();
            $table->integer('plan_mes_petroleo');
            $table->integer('plan_real_petroleo')->nullable();
            $table->integer('porciento_petroleo')->nullable();
            $table->timestamps();

            $table->foreign('ueb_id')->references('id')->on('uebs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('energias');
    }
}
