<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsForStoreInvoices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comprobante', function (Blueprint $table) {
            $table->dropColumn('tipo_impresora');
            $table->string('serie', 15)->after('tipo')->default('0001')->nullable();
            $table->integer('pad_izquierda')->default(8);
        });

        Schema::table('deuda_ingreso', function (Blueprint $table) {
            $table->enum('tipo_comprobante', ['comprobante', 'boleta', 'factura'])->nullable();
            $table->string('serie_comprobante', 15)->nullable();
            $table->string('numero_comprobante', 15)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comprobante', function (Blueprint $table) {
            //
        });
    }
}
