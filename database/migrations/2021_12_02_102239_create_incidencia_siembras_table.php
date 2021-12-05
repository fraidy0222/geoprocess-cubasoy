<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncidenciaSiembrasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incidencia_siembras', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('cultivo_id')->nullable();
            $table->unsignedBigInteger('ueb_id')->nullable();
            $table->unsignedBigInteger('siembra_id')->nullable();
            $table->integer('cc')->default(0);
            $table->double('area', 8, 2)->default(0);
            $table->integer('siembrap')->default(0);
            $table->integer('siembraa')->default(0);
            $table->integer('siembrad')->default(0);
            $table->integer('cantsemillad')->default(0);
            $table->integer('cantsemillaa')->default(0);
            $table->integer('cantsemillaud')->default(0);
            $table->integer('cantsemillaua')->default(0);
            $table->timestamps();

            $table->foreign('cultivo_id')->references('id')->on('cultivos')->onDelete('cascade');
            $table->foreign('ueb_id')->references('id')->on('uebs')->onDelete('cascade');
            $table->foreign('siembra_id')->references('id')->on('siembras')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('incidencia_siembras');
    }
}
