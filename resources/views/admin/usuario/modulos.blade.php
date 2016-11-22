@extends('layouts.dashboard')

@section('title')
  Definir Módulos de Usuario
@endsection

@section('content')
  @if(Session::has('message'))
  <div class="row">
    <div class="col-sm-10">
      <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        {{ Session::get('message') }}
      </div>
    </div>
  </div>
  @endif

  @include('messages.errors')

  <div class="row" ng-app="definirModulosUsuario" ng-controller="modulosController">
    <div class="col-sm-10">
      <div class="card hoverable">
        <div class="card-header main-color ch-alt">
          <h2>Definir Módulos de Usuario</h2>
        </div>
        <div class="card-body card-padding">
          <form action="" class="form-horizontal">
            <div class="form-group">
              <label for="usuario" class="control-label col-sm-3">Usuario</label>
              <div class="col-sm-9">
                <div class="fg-line">
                  <div class="select">
                    <select name="usuario" id="usuario" class="form-control text-uppercase" ng-options="usuario.nombre for usuario in usuarios" ng-model="usuario" ng-change="cargarModulos()">
                      <option value="">Seleccione Usuario</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-hr"></div>
            <table class="table table-bordered">
              <tr class="accent-color">
                <td>Módulo</td>
                <td></td>
              </tr>
              <tr ng-repeat="modulo in modulos">
                <td>{@ modulo.descripcion @}</td>
                <td>
                  <div class="checkbox table-checkbox">
                    <label>
                      <input type="checkbox" ng-model="modulo.seleccionado">
                      <i class="input-helper"></i>
                      Seleccionar
                    </label>
                  </div>
                </td>
              </tr>
            </table>
            <div class="form-group">
              <div class="col-sm-3 col-sm-offset-9">
                <button type="button" class="btn btn-block waves-effect m-t-15 accent-color" ng-click="guardarModulos()" ng-disabled="procesando || !usuario">
                  <span ng-hide="procesando">Guardar</span>
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
  </div>
@endsection

@section('scripts')
  <script src="{{ asset('js/angular.min.js') }}"></script>
  <script src="{{ asset('js/apps/modulos.definir.js') }}"></script>
@endsection
