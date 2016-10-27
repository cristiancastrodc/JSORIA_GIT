<?php

namespace JSoria;

use Illuminate\Database\Eloquent\Model;

class CategoriaTemp extends Model
{
  protected $table = 'categorias_temp';

  protected $fillable = ['id_detalle_institucion', 'estado', 'monto_matricula', 'monto_pension', 'concepto_matricula', 'concepto_pension', 'periodo'];

  // Custom
  public $timestamps = false;

  // Recuperar categorías que se deben programar
  public static function categoriasParaProgramar($id_institucion)
  {
    return CategoriaTemp::join('detalle_institucion', 'id_detalle_institucion', '=', 'detalle_institucion.id')
                        ->where('id_institucion', $id_institucion)
                        ->where('estado', 0)
                        ->select('categorias_temp.id', 'nombre_division', 'concepto_matricula', 'id_detalle_institucion', 'monto_matricula', 'monto_pension', 'concepto_matricula', 'concepto_pension', 'periodo')
                        ->get();
  }
}
