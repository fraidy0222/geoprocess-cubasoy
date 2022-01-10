<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncidenciaCulturalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incidencia_culturales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('ueb_id')->nullable();
            $table->unsignedBigInteger('cultivo_id')->nullable();
            $table->unsignedBigInteger('culturale_id')->nullable();
            $table->integer('cc')->default(0);
            $table->integer('tipo_peloton')->default(0);
            $table->integer('c_plan')->default(0);
            $table->integer('c_acum')->default(0);
            $table->integer('c_diario')->default(0);
            $table->integer('p_plan')->default(0);
            $table->integer('p_acum')->default(0);
            $table->integer('p_diario')->default(0);
            $table->integer('l_plan')->default(0);
            $table->integer('l_acum')->default(0);
            $table->integer('l_diario')->default(0);
            $table->integer('ch_plan')->default(0);
            $table->integer('ch_acum')->default(0);
            $table->integer('ch_diario')->default(0);
            $table->integer('d_d')->default(0);
            $table->timestamps();

            $table->foreign('ueb_id')->references('id')->on('uebs')->onDelete('cascade');
            $table->foreign('cultivo_id')->references('id')->on('cultivos')->onDelete('cascade');
            $table->foreign('culturale_id')->references('id')->on('culturales')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('incidencia_culturales');
    }
}
