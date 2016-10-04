<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTableIngresosTesorera extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingresos_tesorera', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_tesorera');
            $table->integer('id_institucion');
            $table->decimal('monto', 10, 2);
            $table->timestamps();

            $table->foreign('id_tesorera')->references('id')->on('usuario');
            $table->foreign('id_institucion')->references('id')->on('institucion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
