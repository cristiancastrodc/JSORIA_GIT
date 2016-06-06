<?php

namespace JSoria;

use Illuminate\Database\Eloquent\Model;

class TipoComprobante extends Model
{
  protected $table = 'tipo_comprobante';
  protected $fillable = ['id', 'denominacion'];
  public $timestamps = false;
}
