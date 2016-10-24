<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriaTempsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categorias_temp', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_detalle_institucion');
            $table->boolean('estado');
            $table->decimal('monto_matricula', 10, 2);
            $table->decimal('monto_pension', 10, 2);
            $table->string('concepto_matricula');
            $table->string('concepto_pension');
            $table->string('periodo', 20);
            // Foreign keys
            $table->foreign('id_detalle_institucion')->references('id')->on('detalle_institucion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('categoria_temps');
    }
}
