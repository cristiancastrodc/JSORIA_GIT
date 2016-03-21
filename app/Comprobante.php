<?php

namespace JSoria;

use Illuminate\Database\Eloquent\Model;

class Comprobante extends Model
{
  protected $table = 'comprobante';

  protected $fillable = ['numero_comprobante'];

  public $timestamps = false;
}
