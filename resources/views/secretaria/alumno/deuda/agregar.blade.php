@extends('layouts.dashboard')

@section('title')
  Agregar Deuda
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

  <div ng-app="administrarAlumnos" ng-controller="agregarDeudasController">
    <div class="row">
      <div class="col-md-12">
        <div class="card hoverable">
          <div class="card-header main-color ch-alt">
            <h2>Agregar Deuda</h2>
          </div>
          <div class="card-body card-padding" ng-hide="existeAlumno">
            <form class="form-horizontal" id="form-categorias-alumno">
              <div class="form-group">
                <label for="nro_documento" class="col-sm-3 control-label">Alumno</label>
                <div class="col-sm-9">
                  <div class="fg-line">
                    <input type="text" class="form-control" id="nro_documento" placeholder="Ingresar DNI o Código del Alumno" ng-model="alumno.nro_documento">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-3 col-sm-offset-9">
                  <button class="btn btn-block accent-color waves-effect" ng-click="buscarAlumno()" ng-disabled="!alumno.nro_documento"><i class="zmdi zmdi-search"></i> Buscar</button>
                </div>
              </div>
            </form>
          </div>
          <div ng-show="existeAlumno">
            <div class="card-body card-padding">
              <h3 class="text-uppercase">{@ alumno.nombre @}</h3>
              <h4>{@ alumno.institucion || '(Alumno no matriculado actualmente)' @}</h4>
            </div>
            <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th class="accent-color c-white"></th>
                    <th class="accent-color c-white">Institución</th>
                    <th class="accent-color c-white">Concepto</th>
                    <th class="accent-color c-white">Monto (unitario)</th>
                    <th class="accent-color c-white">Factor / Cantidad</th>
                    <th class="accent-color c-white">Total (S/)</th>
                  </tr>
                  <tr class="search-row">
                    <th></th>
                    <th><input type="text" class="form-control table-input" placeholder="Buscar..." ng-model="busqueda.institucion"></th>
                    <th><input type="text" class="form-control table-input" placeholder="Buscar..." ng-model="busqueda.concepto"></th>
                    <th></th>
                    <th></th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr ng-repeat="concepto in conceptos | filter : { institucion : busqueda.institucion } : filtroInstitucion | filter : { nombre : busqueda.concepto } : filtroConcepto" class="v-m">
                    <td>
                      <div class="checkbox table-checkbox">
                        <label>
                          <input type="checkbox" ng-model="concepto.seleccionado" ng-change="actualizarConcepto(concepto)">
                          <i class="input-helper"></i>
                        </label>
                      </div>
                    </td>
                    <td>{@ concepto.institucion @}</td>
                    <td>{@ concepto.nombre @}</td>
                    <td class="text-right">{@ concepto.monto @}</td>
                    <td>
                      <input type="number" class="form-control table-input text-right" ng-model="concepto.factor" placeholder="Valor" ng-change="calcularTotal(concepto)" ng-disabled="!concepto.seleccionado">
                    </td>
                    <td class="text-right">{@ concepto.total | number:2 @}</td>
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
                    <button class="btn btn-block accent-color waves-effect" ng-click="agregarDeuda()" ng-disabled="procesando || !esValidoConceptos()">
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
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script src="{{ asset('js/angular.min.js') }}"></script>
  <script src="{{ asset('js/apps/alumnos.administrar.js') }}"></script>
@endsection
