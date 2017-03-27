<?php namespace JSoria;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

use DB;
use Auth;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

  use Authenticatable, CanResetPassword;

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'usuario';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['dni', 'nombres', 'apellidos', 'tipo', 'usuario_login', 'password'];

  /**
   * The attributes excluded from the model's JSON form.
   *
   * @var array
   */
  protected $hidden = ['password', 'remember_token'];

  /*** Custom ***/
  public $timestamps = false;

  /*** Set Password ***/
  public function setPasswordAttribute($value)
  {
    if (!empty($value)) {
      $this->attributes['password'] = \Hash::make($value);
    }
  }

  /*** Recuperar cajeras ***/
  public static function getUsuarioCajera()
  {
    return User::where('tipo', '=', 'cajera')
           ->select('id', 'nombres', 'apellidos')
           ->get();
  }

  /*** Recuperar cajeras asociadas a la tesorera ***/
  public static function getCajerasTesorera($id_tesorera)
  {
    return User::join('permisos', 'usuario.id', '=', 'permisos.id_usuario')
           ->where('tipo', '=', 'cajera')
           ->whereIn('permisos.id_institucion', function ($query) use ($id_tesorera) {
              $query->select('id_institucion')
                    ->from('permisos')
                    ->where('id_usuario', $id_tesorera);
           })
           ->select('usuario.id', 'usuario.nombres', 'usuario.apellidos')
           ->distinct()->get();
  }

  /*** Recuperar lista de tesoreras ***/
  public static function getTesoreras()
  {
    return User::where('tipo', '=', 'tesorera')
           ->select('id', 'nombres', 'apellidos')
           ->get();
  }
  /**
   * Retorna la lista de usuarios
   */
  public static function listaUsuarios()
  {
    if (Auth::user()->usuario_login == 'sysadmin') {
      return User::select('usuario.id', DB::raw("CONCAT(jsoria_usuario.nombres, ' ', jsoria_usuario.apellidos, ' ', ' -', ' ', jsoria_usuario.tipo) as nombre"))
               ->get();
    }
    else {
      return User::select('usuario.id', DB::raw("CONCAT(jsoria_usuario.nombres, ' ', jsoria_usuario.apellidos, ' ', ' -', ' ', jsoria_usuario.tipo) as nombre"))
                 ->where('usuario_login', '<>', 'sysadmin')
                 ->get();
    }
  }
  /**
   * Retorna la lista de usuarios cajera
   */
  public static function getCajeras()
  {
    return User::where('tipo', '=', 'Cajera')
           ->select('id', 'nombres', 'apellidos')
           ->get();
  }
}
