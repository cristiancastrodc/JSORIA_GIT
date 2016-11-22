<?php

use Illuminate\Database\Seeder;

class ModulosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('modulos')->insert(
        ['url' => '', 'icono' => '', 'descripcion' => '', 'tipo_usuario' => '']
      );
    }
}
