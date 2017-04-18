<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddActionsToFksOnDeudaIngresoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('deuda_ingreso', function (Blueprint $table) {
            $table->dropForeign('fk_alumno_deuda');
            $table->foreign('id_alumno')
                  ->references('nro_documento')->on('alumno')
                  ->onUpdate('cascade');
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
            $table->dropForeign('id_alumno');
        });
    }
}
