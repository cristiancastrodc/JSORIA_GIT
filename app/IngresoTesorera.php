<?php

namespace JSoria;

use Illuminate\Database\Eloquent\Model;

class IngresoTesorera extends Model
{
  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'ingresos_tesorera';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['id_tesorera', 'id_institucion', 'monto'];
}
