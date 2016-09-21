<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRazonSocialAndResponsableToEgreso extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('egreso', function (Blueprint $table) {
            $table->string('razon_social')->nullable();
            $table->string('responsable')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('egreso', function (Blueprint $table) {
            //
        });
    }
}
