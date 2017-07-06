@extends('layouts.dashboard')

@section('title', 'Cancelar deuda de actividad')

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

  <div ng-app="administrarAlumnos" ng-controller="cancelarActividadController">
    <div class="row">
      <div class="col-md-12">
        <div class="card hoverable">
          <div class="card-header main-color ch-alt">
            <h2>Cancelar Deuda de Actividad</h2>
          </div>
          <div ng-hide="alumnoExiste">
            <div class="card-body card-padding">
              <form class="form-horizontal">
                <div class="form-group">
                  <label for="nro_documento" class="col-sm-3 control-label">Alumno</label>
                  <div class="col-sm-9">
                    <div class="fg-line">
                      <input type="text" class="form-control input-sm" id="nro_documento" name="nro_documento" placeholder="Ingrese DNI o Código del Alumno" ng-model="nro_documento">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-3 col-sm-offset-9">
                    <button class="btn btn-block accent-color waves-effect" ng-click="buscarAlumno()" ng-disabled="buscando || nro_documento == ''">
                      <span ng-hide="buscando"><i class="zmdi zmdi-search"></i> Buscar</span>
                      <span ng-show="buscando">
                        <span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> Buscando...
                      </span>
                    </button>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <div ng-show="alumnoExiste">
            <div class="card-body card-padding">
              <h3 class="text-uppercase">{@ alumno.apellidos @}, {@ alumno.nombres @}</h3>
              <h4>{@ alumno.institucion || '(Alumno no matriculado actualmente)' @}</h4>
            </div>
            <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th class="accent-color c-white">Institución</th>
                    <th class="accent-color c-white">Concepto</th>
                    <th class="accent-color c-white">Monto (S/)</th>
                    <th class="accent-color c-white">¿Cancelar?</th>
                  </tr>
                  <tr class="search-row">
                    <th><input type="text" class="form-control table-input" placeholder="Buscar..." ng-model="busqueda.institucion"></th>
                    <th><input type="text" class="form-control table-input" placeholder="Buscar..." ng-model="busqueda.concepto"></th>
                    <th></th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr ng-repeat="deuda in deudas | filter : { institucion : busqueda.institucion } : filtroInstitucion | filter : { nombre : busqueda.concepto } : filtroConcepto" class="v-m">
                    <td>{@ deuda.institucion @}</td>
                    <td>{@ deuda.nombre @}</td>
                    <td class="text-right">{@ deuda.monto | number:2 @}</td>
                    <td>
                      <div class="checkbox table-checkbox">
                        <label>
                          <input type="checkbox" ng-model="deuda.seleccionada">
                          <i class="input-helper"></i>
                        </label>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="card-body card-padding">
              <form class="form-horizontal">
                <div class="form-group">
                  <div class="col-sm-3 col-sm-offset-6">
                    <button class="btn btn-block btn-link waves-effect" type="button" ng-click="inicializar()"><i class="zmdi zmdi-close-circle-o"></i> Cancelar</button>
                  </div>
                  <div class="col-sm-3">
                    <button class="btn btn-block accent-color waves-effect" ng-click="cancelarDeudas()" ng-disabled="procesando || !esValidoFormEdicion()">
                      <span ng-hide="procesando"><i class="zmdi zmdi-assignment-check"></i> Cancelar Deudas</span>
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
    </div>
  </div>
@endsection

@section('scripts')
  <script src="{{ asset('js/angular.min.js') }}"></script>
  <script src="{{ asset('js/apps/alumnos.administrar.js') }}"></script>
@endsection
