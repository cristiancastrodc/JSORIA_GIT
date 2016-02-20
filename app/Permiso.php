<?php namespace JSoria;

use Illuminate\Database\Eloquent\Model;

class Permiso extends Model {

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'permisos';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['id_institucion', 'id_usuario'];

  /*** Custom ***/
  public $timestamps = false;

}
