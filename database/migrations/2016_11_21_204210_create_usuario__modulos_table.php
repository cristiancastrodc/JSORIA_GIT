<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuarioModulosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuario_modulos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_usuario')->nullable;
            $table->integer('id_modulo')->nullable;

            $table->foreign('id_usuario')->references('id')->on('usuario');
            $table->foreign('id_modulo')->references('id')->on('modulos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('usuario__modulos');
    }
}
