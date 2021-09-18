<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAusenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ausencias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('ueb_id')->nullable();
            $table->integer('certificados_medicos')->default(0);
            $table->integer('lic_maternidad')->default(0);
            $table->integer('vacaciones')->default(0);
            $table->integer('aus_autorizadas')->default(0);
            $table->integer('aus_injustificadas')->default(0);
            $table->integer('otras')->default(0);
            $table->integer('aislados')->default(0);
            $table->integer('positivos')->default(0);
            $table->integer('madres_ninnos')->default(0);
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
        Schema::dropIfExists('ausencias');
    }
}
