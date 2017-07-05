@extends('layouts.dashboard')

@section('title', 'Reporte de Cuenta de Alumno')

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

  <div ng-app="reporteCuentaAlumno" ng-controller="reporteCuentaAlumnoController">
    <div class="row">
      <div class="col-md-12">
        <div class="card hoverable">
          <div class="card-header main-color ch-alt">
            <h2>Reporte De Cuenta de Alumno</h2>
          </div>
          <div class="card-body card-padding">
            <form action="{{ url('/secretaria/reportes/cuenta_alumno/procesar') }}" class="form-horizontal" method="POST" id="cuenta_alumno">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <div ng-hide="hayAlumno">
                <div class="form-group">
                  <label for="nro_documento" class="control-label col-sm-3">Alumno</label>
                  <div class="col-sm-9">
                    <div class="fg-line">
                      <input type="text" class="form-control" id="nro_documento" name="nro_documento" placeholder="DNI o Código del alumno" ng-model="alumno.nro_documento">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-3 col-sm-offset-9">
                    <button class="btn btn-block accent-color waves-effect" type="button" ng-click="buscar()" ng-disabled="buscando">
                      <span ng-hide="buscando">Buscar</span>
                      <span ng-show="buscando">
                        <span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> Buscando...
                      </span>
                    </button>
                  </div>
                </div>
              </div>
              <div ng-show="hayAlumno">
                <h3 class="text-uppercase m-t-0">{@ alumno.apellidos @}, {@ alumno.nombres @}</h3>
                <div class="form-group">
                  <label for="categoria" class="control-label col-sm-3">Período:</label>
                  <div class="col-sm-9">
                    <div class="fg-line">
                      <div class="select">
                        <select name="categoria" id="id_categoria" class="form-control" ng-options="categoria.periodo for categoria in categorias" ng-model="categoria">
                          <option value="">Seleccione Período</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                <input type="hidden" value="{@ categoria.id @}" name="id_categoria">
                <input type="hidden" value="{@ categoria.periodo @}" name="periodo">
                <!-- EXCEL O PDF -->
                <div class="form-group">
                  <label for="tipo_reporte" class="control-label col-sm-3">Tipo de Reporte</label>
                  <div class="col-sm-9">
                    <div class="radio">
                      <label>
                        <input type="radio" name="tipo_reporte" value="pdf" checked="checked">
                        <i class="input-helper"></i>PDF
                      </label>
                    </div>
                    <div class="radio">
                      <label>
                        <input type="radio" name="tipo_reporte" value="excel">
                        <i class="input-helper"></i>Excel
                      </label>
                    </div>
                  </div>
                </div>
                <!--/ EXCEL O PDF -->
                <div class="form-group">
                  <div class="col-sm-3 col-sm-offset-9">
                    <button type="submit" class="btn btn-block waves-effect accent-color" formtarget="_blank">Generar</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script src="{{ asset('js/angular.min.js') }}"></script>
  <script src="{{ asset('js/apps/reportes/secretaria.cuenta_alumno.js') }}"></script>
  <script>
    $(document).on('keypress', 'form#cuenta_alumno', function(event) {
      return event.keyCode != 13;
    });
  </script>
@endsection
