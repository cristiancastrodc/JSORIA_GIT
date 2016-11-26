<?php

use Illuminate\Database\Seeder;

class SysAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('usuario')->insert(
        ['dni' => 'sysadmin', 'nombres' => 'sysadmin', 'apellidos' => '', 'tipo' => 'Administrador', 'usuario_login' => 'sysadmin', 'password' => \Hash::make('soriaSYSadmin')]
      );
    }
}
