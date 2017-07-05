@extends('layouts.dashboard')

@section('title', 'Modificar Deudas de Alumno')

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

  <div ng-app="modificarDeuda" ng-controller="modificarDeudaController">
    <div class="row">
      <div class="col-md-12">
        <div class="card hoverable">
          <div class="card-header main-color ch-alt">
            <h2>Modificar Deudas</h2>
          </div>
          <form class="form-horizontal">
            <div class="card-body card-padding">
              <div ng-hide="agregando || finalizando">
                <div class="form-group">
                  <label for="nro_documento" class="col-sm-3 control-label">Alumno</label>
                  <div class="col-sm-9">
                    <div class="fg-line">
                      <input type="text" class="form-control" id="nro_documento" name="nro_documento" placeholder="Ingrese DNI o Código del Alumno" ng-model="nro_documento">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-3 col-sm-offset-9">
                    <button class="btn btn-block accent-color waves-effect" ng-click="buscar()" ng-disabled="buscando || nro_documento==''">
                      <span ng-hide="buscando"><i class="zmdi zmdi-search"></i> Buscar</span>
                      <span ng-show="buscando">
                        <span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> Buscando...
                      </span>
                    </button>
                  </div>
                </div>
              </div>
              <div ng-show="agregando || finalizando">
                <h3 class="text-uppercase m-t-0">{@ alumno.apellidos @}, {@ alumno.nombres @}</h3>
                <h4 class="text-uppercase m-t-0">{@ alumno.institucion @} - {@ alumno.division @} - {@ alumno.grado @}</h4>
              </div>
            </div>
            <div ng-show="agregando">
              <div class="table-responsive">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th class="accent-color c-white">Institución</th>
                      <th class="accent-color c-white">Deuda</th>
                      <th class="accent-color c-white">Monto (S/)</th>
                      <th class="accent-color c-white">Descuento (S/)</th>
                      <th class="accent-color c-white">¿Anular?</th>
                    </tr>
                    <tr class="search-row">
                      <th><input type="text" class="form-control table-input" placeholder="Buscar..." ng-model="busqueda.institucion"></th>
                      <th><input type="text" class="form-control table-input" placeholder="Buscar..." ng-model="busqueda.concepto"></th>
                      <th></th>
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
                        <input type="number" ng-model="deuda.descuento" class="form-control table-input text-right" min="0" max="{@ deuda.monto @}" placeholder="Descuento">
                      </td>
                      <td>
                        <div class="checkbox table-checkbox">
                          <label>
                            <input type="checkbox" ng-model="deuda.anulada">
                            <i class="input-helper"></i>
                          </label>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="card-body card-padding">
                <div class="form-group">
                  <label for="rd" class="control-label col-sm-3">Resolución:</label>
                  <div class="col-sm-9">
                    <div class="fg-line">
                      <input type="text" name="rd" id="rd" class="form-control" placeholder="Número de Resolucion" ng-model="resolucion">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-4 col-sm-offset-4">
                    <button class="btn btn-block btn-link waves-effect" type="button" ng-click="inicializar()"><i class="zmdi zmdi-close-circle-o"></i> Cancelar</button>
                  </div>
                  <div class="col-sm-4">
                    <button class="btn btn-block accent-color waves-effect" ng-click="mostrarResumen()" ng-disabled="!esValidoFormEdicion()"><i class="zmdi zmdi-assignment-check"></i> Siguiente</button>
                  </div>
                </div>
              </div>
            </div>
            <div ng-show="finalizando">
              <div class="table-responsive">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th class="accent-color c-white">Institución</th>
                      <th class="accent-color c-white">Deuda</th>
                      <th class="accent-color c-white">Monto (S/)</th>
                      <th class="accent-color c-white">Descuento (S/)</th>
                      <th class="accent-color c-white text-center">Observaciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr ng-repeat="deuda in deudas_seleccionadas" class="v-m">
                      <td>{@ deuda.institucion @}</td>
                      <td>{@ deuda.nombre @}</td>
                      <td class="text-right">{@ deuda.monto | number:2 @}</td>
                      <td class="text-right">{@ deuda.anulada? '':(deuda.descuento | number:2) @}</td>
                      <td class="text-center">{@ deuda.anulada? 'Anulada':'' @}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="card-body card-padding">
                <div class="form-group">
                  <div class="col-sm-4 col-sm-offset-4">
                    <button class="btn btn-block btn-link waves-effect" type="button" ng-click="volver()"><i class="zmdi zmdi-close-circle-o"></i> Volver</button>
                  </div>
                  <div class="col-sm-4">
                    <button class="btn btn-block accent-color waves-effect" ng-click="guardar()" ng-disabled="procesando">
                      <span ng-hide="procesando"><i class="zmdi zmdi-assignment-check"></i> Guardar</span>
                      <span ng-show="procesando">
                        <span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> Procesando...
                      </span>
                    </button>
                  </div>
                </div>
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
  <script src="{{ asset('js/apps/modificar.deudas.administrar.js') }}"></script>
@endsection