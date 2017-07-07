@extends('layouts.dashboard')

@section('title')
  Administrar Usuarios
@endsection

@section('content')

  @if(Session::has('message'))
  <div class="row">
    <div class="col-sm-12">
      <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        {{ Session::get('message') }}
      </div>
    </div>
  </div>
  @endif

  @include('messages.errors')

  <div ng-app="administrarUsuarios" ng-controller="usuariosController">
    <div class="row">
      <div class="col-md-6">
        <div class="card hoverable">
          <div class="card-header main-color ch-alt">
            <h2>Nuevo Usuario</h2>
          </div>
          <div class="card-body card-padding">
            <form class="form-horizontal">
              <div class="form-group">
                <label for="dni" class="col-sm-3 control-label">DNI</label>
                <div class="col-sm-9">
                  <div class="fg-line">
                    <input type="text" class="form-control input-sm" id="dni" name="dni" placeholder="DNI" data-mask="00000000" ng-model="usuario.dni">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="nombres" class="col-sm-3 control-label">Nombres</label>
                <div class="col-sm-9">
                  <div class="fg-line">
                    <input type="text" class="form-control input-sm" id="nombres" name="nombres" placeholder="Nombres" ng-model="usuario.nombres">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="apellidos" class="col-sm-3 control-label">Apellidos</label>
                <div class="col-sm-9">
                  <div class="fg-line">
                    <input type="text" class="form-control input-sm" id="apellidos" name="apellidos" placeholder="Apellidos" ng-model="usuario.apellidos">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="tipo" class="col-sm-3 control-label">Tipo</label>
                <div class="col-sm-9">
                   <div class="fg-line">
                    <div class="select">
                      <select class="form-control" id="tipo" ng-model="usuario.tipo" ng-options="tipo.value as tipo.label for tipo in tipos_usuario">
                        <option value="" disabled="">-- SELECCIONE TIPO DE USUARIO --</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="permisos" class="col-sm-3 control-label">Permisos</label>
                <div class="col-sm-9">
                  <div class="fg-line">
                    <div class="select">
                      <select class="chosen" multiple="" id="permisos" ng-options="institucion.id_institucion as institucion.nombre for institucion in instituciones" ng-model="usuario.permisos" chosen data-placeholder="-- SELECCIONE INSTITUCIONES --">
                        <option value="" disabled="">-- SELECCIONE INSTITUCIONES --</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="user" class="col-sm-3 control-label">Usuario</label>
                <div class="col-sm-9">
                  <div class="fg-line">
                    <input type="text" class="form-control input-sm" id="usuario_login" name="usuario_login" placeholder="Usuario" ng-model="usuario.login">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="password" class="col-sm-3 control-label">Contraseña</label>
                <div class="col-sm-9">
                  <div class="fg-line">
                    <input type="password" class="form-control input-sm" id="password" name="password" placeholder="Contraseña" ng-model="usuario.password">
                  </div>
                </div>
              </div>
              <input type="password" class="fake_pass" id="fake_pass" name="fake_pass">
              <div class="form-group">
                <div class="col-md-5 col-md-offset-2">
                  <button class="btn btn-block btn-link waves-effect" type="button" ng-click="inicializar()" id="btn-inicializar" chosen-updater><i class="zmdi zmdi-close-circle-o"></i> Cancelar</button>
                </div>
                <div class="col-sm-5">
                  <button class="btn btn-block accent-color waves-effect" ng-click="guardarUsuario()" ng-disabled="procesando || !esValidoFormCreacion()">
                    <span ng-hide="procesando"><i class="zmdi zmdi-assignment-check"></i> Grabar</span>
                    <span ng-show="procesando">
                      <span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> Procesando...
                    </span>
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card hoverable">
          <div class="card-header main-color ch-alt">
            <h2>Lista de Usuarios</h2>
          </div>
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th class="accent-color c-white">Nombres</th>
                  <th class="accent-color c-white">Apellidos</th>
                  <th class="accent-color c-white">Tipo</th>
                  <th class="accent-color c-white">Acciones</th>
                </tr>
                <tr class="search-row">
                  <th><input type="text" class="form-control table-input" placeholder="Buscar..." ng-model="busqueda.nombre"></th>
                  <th><input type="text" class="form-control table-input" placeholder="Buscar..." ng-model="busqueda.apellidos"></th>
                  <th><input type="text" class="form-control table-input" placeholder="Buscar..." ng-model="busqueda.tipo"></th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <tr ng-repeat="usuario in usuarios | filter : { nombres : busqueda.nombre } : filtroNombre | filter : { apellidos : busqueda.apellidos } : filtroApellidos | filter : { tipo : busqueda.tipo } : filtroTipo">
                  <td>{@ usuario.nombres @}</td>
                  <td>{@ usuario.apellidos @}</td>
                  <td>{@ usuario.tipo @}</td>
                  <td>
                    <div class="btn-group btn-group-sm" role="group">
                      <a ng-href="/admin/usuarios/{@ usuario.id @}/edit" class="btn third-color" data-toggle="tooltip" data-placement="top" data-original-title="Modificar" tooltip><i class="zmdi zmdi-edit"></i></a>
                      <a class='btn fourth-color waves-effect' ng-click="eliminarUsuario(usuario.id)" ><i class='zmdi zmdi-delete'></i></a>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script src="{{ asset('js/angular.min.js') }}"></script>
  <script src="{{ asset('js/apps/usuarios.administrar.js') }}"></script>
@endsection
