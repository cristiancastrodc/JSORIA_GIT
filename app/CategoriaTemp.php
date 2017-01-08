<?php

namespace JSoria;

use Illuminate\Database\Eloquent\Model;

class CategoriaTemp extends Model
{
  protected $table = 'categorias_temp';

  protected $fillable = ['id_detalle_institucion', 'estado', 'monto_matricula', 'monto_pension', 'concepto_matricula', 'concepto_pension', 'periodo', 'batch'];

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
  /**
   * Retorna el número siguiente del batch
   */
  public static function siguienteNroBatch()
  {
    return CategoriaTemp::max('batch') + 1;
  }
  /**
   * Retorna las categorías temporales asociadas a un batch
   */
  public static function categoriasPorBatch($batch)
  {
    return CategoriaTemp::where('batch', $batch)
                        ->join('detalle_institucion', 'categorias_temp.id_detalle_institucion', '=', 'detalle_institucion.id')
                        ->select('detalle_institucion.nombre_division', 'categorias_temp.concepto_matricula', 'categorias_temp.monto_matricula', 'categorias_temp.concepto_pension', 'categorias_temp.monto_pension')
                        ->get();
  }
}
