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
      #Administrador
      DB::table('modulos')->insert(
        ['descripcion' => 'Actividades', 'tipo_usuario' => 'Administrador', 'tag_id' => 'link_actividades']
      );
      DB::table('modulos')->insert(
        ['descripcion' => 'Crear Matrícula', 'tipo_usuario' => 'Administrador', 'tag_id' => 'link_crear_matricula']
      );
      DB::table('modulos')->insert(
        ['descripcion' => 'Cobros Ordinarios', 'tipo_usuario' => 'Administrador', 'tag_id' => 'link_cobros_ordinarios']
      );
      DB::table('modulos')->insert(
        ['descripcion' => 'Cobros Extraordinarios', 'tipo_usuario' => 'Administrador', 'tag_id' => 'link_cobros_extraordinarios']
      );
      DB::table('modulos')->insert(
        ['descripcion' => 'Otros Cobros', 'tipo_usuario' => 'Administrador', 'tag_id' => 'link_otros_cobros']
      );
      DB::table('modulos')->insert(
        ['descripcion' => 'Definir Comprobantes', 'tipo_usuario' => 'Administrador', 'tag_id' => 'link_crear_comprobante']
      );
      DB::table('modulos')->insert(
        ['descripcion' => 'Usuarios', 'tipo_usuario' => 'Administrador', 'tag_id' => 'link_usuarios']
      );
      DB::table('modulos')->insert(
        ['descripcion' => 'Autorizar Descuentos', 'tipo_usuario' => 'Administrador', 'tag_id' => 'link_autorizacion']
      );
      DB::table('modulos')->insert(
        ['descripcion' => 'Retiro', 'tipo_usuario' => 'Administrador', 'tag_id' => 'link_ingresos']
      );
      DB::table('modulos')->insert(
        ['descripcion' => 'Definir Descuentos', 'tipo_usuario' => 'Administrador', 'tag_id' => 'link_configuracion']
      );
      #Cajera
      DB::table('modulos')->insert(
        ['descripcion' => 'Otros Cobros', 'tipo_usuario' => 'Cajera', 'tag_id' => 'link_otros_cobros']
      );
      #Secretaria
      DB::table('modulos')->insert(
        ['descripcion' => 'Nuevo Alumno', 'tipo_usuario' => 'Secretaria', 'tag_id' => 'link_crear_alumnos']
      );
      DB::table('modulos')->insert(
        ['descripcion' => 'Crear Matrícula', 'tipo_usuario' => 'Secretaria', 'tag_id' => 'link_matricular_alumnos']
      );
      DB::table('modulos')->insert(
        ['descripcion' => 'Añadir Deuda', 'tipo_usuario' => 'Secretaria', 'tag_id' => 'link_deudas_agregar']
      );
      DB::table('modulos')->insert(
        ['descripcion' => 'Modificar Deudas', 'tipo_usuario' => 'Secretaria', 'tag_id' => 'link_modificar_deudas']
      );
      DB::table('modulos')->insert(
        ['descripcion' => 'Cancelar Deuda de Actividad', 'tipo_usuario' => 'Secretaria', 'tag_id' => 'link_cancelar_actividad']
      );
      DB::table('modulos')->insert(
        ['descripcion' => 'Añadir Deudas Anteriores', 'tipo_usuario' => 'Secretaria', 'tag_id' => 'link_deudas_antiguas']
      );
      DB::table('modulos')->insert(
        ['descripcion' => 'Programar Períodos', 'tipo_usuario' => 'Secretaria', 'tag_id' => 'link_programar_periodos']
      );
      DB::table('modulos')->insert(
        ['descripcion' => 'Cerrar Ciclo', 'tipo_usuario' => 'Secretaria', 'tag_id' => 'link_cerrar_ciclo']
      );
      #Tesorera
      DB::table('modulos')->insert(
        ['descripcion' => 'Registrar Egreso', 'tipo_usuario' => 'Tesorera', 'tag_id' => 'link_registrar_egreso']
      );
      DB::table('modulos')->insert(
        ['descripcion' => 'Modificar Egreso', 'tipo_usuario' => 'Tesorera', 'tag_id' => 'link_modificar_egreso']
      );
      DB::table('modulos')->insert(
        ['descripcion' => 'Rubros', 'tipo_usuario' => 'Tesorera', 'tag_id' => 'link_rubros']
      );
      DB::table('modulos')->insert(
        ['descripcion' => 'Retirar Ingresos', 'tipo_usuario' => 'Tesorera', 'tag_id' => 'link_retiro']
      );
      DB::table('modulos')->insert(
        ['descripcion' => 'Registrar Ingresos Adicionales', 'tipo_usuario' => 'Tesorera', 'tag_id' => 'link_ingresos_adicionales']
      );
    }
}

