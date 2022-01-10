<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTierrasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tierras', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('ueb_id')->nullable();
            $table->integer('cc')->default(0);
            $table->integer('tipo_peloton')->default(0);
            $table->integer('r_plan')->default(0);
            $table->integer('r_acum')->default(0);
            $table->integer('r_diario')->default(0);
            $table->integer('g_plan')->default(0);
            $table->integer('g_acum')->default(0);
            $table->integer('g_diario')->default(0);
            $table->integer('c_plan')->default(0);
            $table->integer('c_acum')->default(0);
            $table->integer('c_diario')->default(0);
            $table->integer('s_plan')->default(0);
            $table->integer('s_acum')->default(0);
            $table->integer('s_diario')->default(0);
            $table->integer('nivelacio_rail')->default(0);
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
        Schema::dropIfExists('tierras');
    }
}
