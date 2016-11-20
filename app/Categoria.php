<?php

namespace JSoria;

use Illuminate\Database\Eloquent\Model;

use Auth;

class Categoria extends Model
{
  protected $table = 'categoria';

  protected $fillable = ['nombre', 'monto', 'tipo', 'estado', 'fecha_inicio', 'fecha_fin', 'destino', 'id_detalle_institucion', 'id_matricula', 'periodo'];

  /*** Custom ***/
  public $timestamps = false;

  public static function matriculasInstitucionAnio($id_institucion, $anio)
  {
    return Categoria::join('detalle_institucion', 'categoria.id_detalle_institucion', '=', 'detalle_institucion.id' )
    ->where('detalle_institucion.id_institucion', '=', $id_institucion)
    ->where('categoria.tipo','=','matricula')
    ->where('categoria.estado', '=', '1')
    ->whereYear('categoria.fecha_inicio', '=', $anio)
    ->select('categoria.id', 'categoria.nombre', 'categoria.monto', 'detalle_institucion.nombre_division')
    ->get();
  }

  public static function pensionesDetalleAnio($id_detalle_institucion, $anio)
  {
    return Categoria::where('id_detalle_institucion', '=', $id_detalle_institucion)
    ->where('tipo','=','pension')
    ->where('estado', '=', '1')
    ->whereYear('fecha_inicio', '=', $anio)
    ->select('id', 'nombre', 'monto')
    ->get();
  }

  public static function actividadesDetalle($id_detalle_institucion)
  {
    return Categoria::where('id_detalle_institucion', '=', $id_detalle_institucion)
    ->where('tipo','=','actividad')
    ->where('estado', '=', '1')
    ->select('id', 'nombre', 'monto')
    ->get();
  }

  public static function cobrosOrdinariosInstitucion($id_institucion)
  {
    return Categoria::join('detalle_institucion', 'categoria.id_detalle_institucion', '=', 'detalle_institucion.id')
    ->where('detalle_institucion.id_institucion', '=', $id_institucion)
    ->whereIn('categoria.tipo', ['con_factor', 'sin_factor'])
    ->select('categoria.id', 'categoria.nombre', 'categoria.monto', 'categoria.estado', 'categoria.tipo', 'categoria.destino')
    ->get();
  }

  public static function otrosCobrosInstitucion($id_institucion)
  {
    return Categoria::join('detalle_institucion', 'categoria.id_detalle_institucion', '=', 'detalle_institucion.id')
    ->where('detalle_institucion.id_institucion', '=', $id_institucion)
    ->where('categoria.tipo', 'multiple')
    ->select('categoria.id', 'categoria.nombre', 'categoria.monto', 'categoria.estado', 'categoria.tipo', 'categoria.destino')
    ->get();
  }

  public static function listaOtrosCobrosCajera()
  {
    return Categoria::join('detalle_institucion', 'categoria.id_detalle_institucion', '=', 'detalle_institucion.id')
                    ->join('institucion', 'detalle_institucion.id_institucion', '=', 'institucion.id')
                    ->where('categoria.tipo', 'multiple')
                    ->where('categoria.estado', '1')
                    ->whereIn('detalle_institucion.id_institucion', function ($query) {
                      $query->select('id_institucion')
                            ->from('permisos')
                            ->where('id_usuario', Auth::user()->id);
                    })
                    ->select('categoria.id as id', 'categoria.nombre as categoria', 'categoria.monto as monto', 'categoria.destino as destino', 'institucion.nombre as institucion')
                    ->get();
  }

  public static function institucionDeCategoria($id_categoria)
  {
    return Categoria::join('detalle_institucion', 'categoria.id_detalle_institucion', '=', 'detalle_institucion.id')
                    ->where('categoria.id', $id_categoria)
                    ->select('detalle_institucion.id_institucion')
                    ->first();
  }
  /**
   * Retorna las matrículas activas para un detalle institución
   */
  public static function matriculasActivas($id_detalle_institucion, $fecha)
  {
    return Categoria::where('tipo', 'matricula')
                    ->where('fecha_fin', '>=', $fecha)
                    ->where('id_detalle_institucion', $id_detalle_institucion)
                    ->where('estado', 1)
                    ->get();
  }
  /**
   * Retorna las pensiones asociadas a una matrícula
   */
  public static function pensionesDeMatricula($id_matricula)
  {
    return Categoria::where('id_matricula', $id_matricula)
                    ->get();
  }
  /**
   * Retorna las matrículas que contienen por lo menos un alumno
   */
  public static function matriculasParaCerrar($id_detalle_institucion)
  {
    return Categoria::where('tipo', 'matricula')
                    ->where('id_detalle_institucion', $id_detalle_institucion)
                    ->where('estado', 1)
                    ->get();
  }
}