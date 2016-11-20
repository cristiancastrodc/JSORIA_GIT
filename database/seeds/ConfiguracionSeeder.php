<?php

use Illuminate\Database\Seeder;

class ConfiguracionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('configuracion')->insert(
        ['variable' => 'dia_limite_descuento', 'valor' => '1']
      );
      DB::table('configuracion')->insert(
        ['variable' => 'porcentaje_descuento', 'valor' => '0']
      );
    }
}
