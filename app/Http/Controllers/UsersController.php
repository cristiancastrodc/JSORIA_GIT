<?php namespace JSoria\Http\Controllers;

use JSoria\Http\Requests;
use JSoria\Http\Requests\UserRequest;
use JSoria\Http\Requests\UserCreateRequest;
use JSoria\Http\Requests\UserUpdateRequest;
use JSoria\Http\Controllers\Controller;
use Auth;
use DB;
use Redirect;
use Session;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use JSoria\Modulo;
use JSoria\Permiso;
use JSoria\User;
use JSoria\UsuarioImpresora;
use JSoria\Usuario_Modulos;

class UsersController extends Controller {

  public function __construct()
  {
    $this->beforeFilter('@find', ['only' => ['edit', 'update', 'destroy']]);
    $this->middleware('auth');
    $this->middleware('admin');
  }

  public function find(Route $route)
  {
    $this->user = User::find($route->getParameter('usuarios'));
    $this->notFound($this->user);
  }

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    /*** Mostrar lista de usuarios ***/
    $users = User::where('usuario_login', '<>', 'sysadmin')->get();
    /*** Mostrar formulario de creacion ***/
    return view('admin.usuario.index', compact('users'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store(UserCreateRequest $request)
  {
    $respuesta = [];
    try {
      DB::beginTransaction();
      // Verificar si existen usuarios con el mismo login
      $usuario_login = $request->input('usuario_login');
      $cantidad_login = User::where('usuario_login', $usuario_login)->count();
      if ($cantidad_login <= 0) {
        // Crear el usuario
        $id_usuario = User::create([
          'dni' => $request->input('dni'),
          'nombres' => $request->input('nombres'),
          'apellidos' => $request->input('apellidos'),
          'tipo' => $request->input('tipo'),
          'usuario_login' => $request->input('usuario_login'),
          'password' => $request->input('password'),
          ])->id;
        // Crear permisos del usuario
        $permisos = $request->input('permisos');
        $permisos_a_crear = [];
        foreach ($permisos as $permiso) {
          array_push($permisos_a_crear, ['id_institucion' => $permiso, 'id_usuario' => $id_usuario]);
        }
        Permiso::insert($permisos_a_crear);
        DB::commit();
        $respuesta['resultado'] = 'true';
      } else {
        $respuesta['resultado'] = 'false';
        $respuesta['mensaje'] = 'Usuario para iniciar sesión ya existe.';
      }
    } catch (\Exception $e) {
      DB::rollback();
      $respuesta['resultado'] = 'false';
      $respuesta['mensaje'] = $e->getMessage();
    }
    return $respuesta;
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
  {
    return view('admin.usuario.edit', ['user' => $this->user]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update($id, UserUpdateRequest $request)
  {
    $this->user->dni = $request['dni'];
    $this->user->nombres = $request['nombres'];
    $this->user->apellidos = $request['apellidos'];
    $this->user->tipo = $request['tipo'];
    $this->user->usuario_login = $request['usuario_login'];
    $this->user->password = $request['password'];

    $this->user->save();

    /*** Borrar todos los permisos actuales ***/
    $affectedRows = Permiso::where('id_usuario', '=', $this->user->id)->delete();

    $permisos = $request->input('permisos');

    foreach ($permisos as $permiso) {
      Permiso::create([
        'id_institucion' => $permiso,
        'id_usuario' => $this->user->id,
        ]);
    }

    Session::flash('message', 'Datos de usuario actualizados.');
    return Redirect::to('/admin/usuarios');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id)
  {
    $data = \JSoria\Retiro::find($id);
    if ($data == null) {
      $affectedRows = Permiso::where('id_usuario', '=', $id)->delete();
      User::destroy($id);
      Session::flash('message', 'Datos de usuario eliminados.');
      return Redirect::to('/admin/usuarios');
    } else {
      Session::flash('message', 'No se pudo eliminar al usuario ya que existen datos relacionados.');
      return Redirect::to('/admin/usuarios');
    }
  }
  /**
   * Muestra el módulo para asignar los módulos de usuario
   */
  public function modulosUsuario()
  {
    return view('admin.usuario.modulos');
  }
  /**
   * Devuelve la lista de Usuarios
   */
  public function listaUsuarios()
  {
    return User::listaUsuarios();
  }
  /**
   * Devuelve la lista de Módulos
   */
  public function listaModulosUsuario($id_usuario)
  {
    $usuario = User::find($id_usuario);
    $tipo = $usuario->tipo;
    $modulos = Modulo::where('tipo_usuario', $tipo)
                     ->select('modulos.id as id_modulo', 'modulos.descripcion')
                     ->get();
    foreach ($modulos as $modulo) {
      $aux = Usuario_Modulos::where('id_modulo', $modulo->id_modulo)
                            ->where('id_usuario', $id_usuario)
                            ->get();
      if ($aux->isEmpty()) {
        $modulo->seleccionado = false;
      } else {
        $modulo->seleccionado = true;
      }
    }
    return $modulos;
  }
  /**
   * Graba la lista de módulos de un usuario
   */
  public function grabarModulosUsuario(Request $request)
  {
    $resultado = 'true';
    // Recuperar
    $id_usuario = $request->input('id_usuario');
    $modulos = $request->input('modulos');
    // Vaciar lista de módulos anterior
    DB::table('usuario_modulos')->where('id_usuario', '=', $id_usuario)->delete();
    // Agregar nuevos módulos
    foreach ($modulos as $modulo) {
      Usuario_Modulos::create([
        'id_usuario' => $id_usuario,
        'id_modulo' => $modulo['id_modulo']
      ]);
    }
    $respuesta = [
      'resultado' => $resultado,
    ];
    return $respuesta;
  }
}
