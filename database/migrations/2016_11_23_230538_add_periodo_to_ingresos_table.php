<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPeriodoToIngresosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('deuda_ingreso', function (Blueprint $table) {
            $table->integer('id_matricula')->nullable();
            $table->foreign('id_matricula')->references('id')->on('categoria');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('deuda_ingreso', function (Blueprint $table) {
            //
        });
    }
}
