<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateToneladasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('toneladas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('cultivo_id')->nullable();
            $table->float('venta_d', 8, 2)->nullable();
            $table->float('acum_mes', 8, 2)->nullable();
            $table->float('acum_fecha', 8, 2)->nullable();
            $table->float('acopio', 8, 2)->nullable();
            $table->float('eam', 8, 2)->nullable();
            $table->float('encarg_estatal', 8, 2)->nullable();
            $table->float('industria', 8, 2)->nullable();
            $table->float('cayo_cruz', 8, 2)->nullable();
            $table->float('i_ceballos', 8, 2)->nullable();
            $table->float('fruta_select', 8, 2)->nullable();
            $table->float('otros', 8, 2)->nullable();
            $table->float('semilla', 8, 2)->nullable();
            $table->float('es_camaguey', 8, 2)->nullable();
            $table->timestamps();

            $table->foreign('cultivo_id')->references('id')->on('cultivos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('toneladas');
    }
}
