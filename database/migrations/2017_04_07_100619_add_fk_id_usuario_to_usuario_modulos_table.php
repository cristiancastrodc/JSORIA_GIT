<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkIdUsuarioToUsuarioModulosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('usuario_modulos', function (Blueprint $table) {
            $table->foreign('id_usuario')->references('id')->on('usuario')
                  ->onDelete('cascade')
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
        Schema::table('usuario_modulos', function (Blueprint $table) {
            $table->dropForeign(['id_usuario']);
        });
    }
}
