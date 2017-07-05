<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEstadoAnuladaToDeudaIngreso extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('deuda_ingreso', function (Blueprint $table) {
            $table->boolean('estado_anulada')->after('estado_fraccionam')->default(false);
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
            $table->dropColumn('estado_anulada');
        });
    }
}
