<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneralsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('generals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('ueb_id')->nullable();
            $table->unsignedBigInteger('cultivo_id')->nullable();
            $table->unsignedBigInteger('tonelada_id')->nullable();
            $table->unsignedBigInteger('valores_id')->nullable();
            $table->unsignedBigInteger('siembra_id')->nullable();
            $table->unsignedBigInteger('culturales_id')->nullable();
            $table->unsignedBigInteger('tierra_id')->nullable();
            $table->unsignedBigInteger('energia_id')->nullable();
            $table->unsignedBigInteger('cosecha_id')->nullable();
            $table->string('nota', 255);
            $table->timestamps();

            $table->foreign('ueb_id')->references('id')->on('uebs')->onDelete('cascade');
            $table->foreign('cultivo_id')->references('id')->on('cultivos')->onDelete('cascade');
            $table->foreign('tonelada_id')->references('id')->on('toneladas')->onDelete('cascade');
            $table->foreign('valores_id')->references('id')->on('valores')->onDelete('cascade');
            $table->foreign('siembra_id')->references('id')->on('siembras')->onDelete('cascade');
            $table->foreign('culturales_id')->references('id')->on('culturales')->onDelete('cascade');
            $table->foreign('tierra_id')->references('id')->on('tierras')->onDelete('cascade');
            $table->foreign('energia_id')->references('id')->on('energias')->onDelete('cascade');
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
        Schema::dropIfExists('generals');
    }
}
