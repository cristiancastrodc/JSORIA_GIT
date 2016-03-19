<?php

namespace JSoria;

use Illuminate\Database\Eloquent\Model;

class UsuarioImpresora extends Model
{
  protected $table = 'usuario_impresora';

  protected $fillable = ['id_cajera', 'tipo_impresora', 'nombre_impresora'];

  public $timestamps = false;

  protected $primaryKey = 'id_cajera';
}