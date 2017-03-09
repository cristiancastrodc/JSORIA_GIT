@extends('layouts.dashboard')

@section('title')
  Autorización Descuento Mediante Resolución
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

  <div class="row" ng-app="autorizarDescuentos" ng-controller="descuentosController">
    <div class="col-md-6">
      <div class="card hoverable">
        <div class="card-header main-color ch-alt">
          <h2>Autorizar Descuento</h2>
        </div>
        <div class="card-body card-padding">
          <form class="form-horizontal">
            <div ng-class="clase_documento">
              <label for="dni" class="col-sm-3 control-label">Documento del Alumno</label>
              <div class="col-sm-9">
                <div class="fg-line">
                  <input type="text" class="form-control" id="nro_documento" name="nro_documento" placeholder="Ingrese DNI o Código de alumno" ng-model="nro_documento" ng-blur="buscarAlumno()">
                </div>
                <small class="help-block" ng-hide="existe_alumno">Código de alumno no registrado.</small>
              </div>
            </div>
            <div class="form-group">
              <label for="datos_alumno" class="col-sm-3 control-label">Alumno</label>
              <div class="col-sm-9">
                <div class="fg-line">
                  <textarea class="form-control" id="datos_alumno" name="datos_alumno" ng-model="datos_alumno" disabled="" rows="3"></textarea>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="fut" class="col-sm-3 control-label">Resolucion</label>
              <div class="col-sm-9">
                <div class="fg-line">
                  <input type="text" class="form-control input-sm" id="resolucion" name="resolucion" placeholder="Numero de RD" ng-model="resolucion">
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="fecha_fin" class="col-sm-3 control-label">Fecha Limite</label>
              <div class="col-sm-9">
                <div class="fg-line">
                  <div class="dtp-container fg-line">
                    <input type='text' class="form-control date-picker" placeholder="Fecha" name="fecha_limite" id="fecha_limite" autocomplete="off" ng-model="fecha_limite">
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-6 col-sm-offset-6">
                <button type="button" class="btn btn-block waves-effect m-t-15 accent-color" ng-click="guardarAutorizacion()" ng-disabled="procesando || !(datos_alumno && resolucion)">
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
  <script src="{{ asset('js/apps/descuentos.administrar.js') }}"></script>
@endsection
