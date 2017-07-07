@extends('layouts.dashboard')

@section('title')
  Cerrar Ciclo
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

  <div class="row" ng-app="cerrarCiclo">
    <div ng-controller="cicloController">
      <div class="col-sm-12">
        <div class="card hoverable">
          <div class="card-header main-color ch-alt">
            <h2>Cerrar Ciclo</h2>
          </div>
          <form action="" class="form-horizontal">
            <div class="card-body card-padding">
              <div class="form-group">
                <label for="institucion" class="control-label col-sm-3">Institución</label>
                <div class="col-sm-9">
                  <div class="fg-line">
                    <div class="select">
                      <select name="institucion" id="institucion" class="form-control" ng-options="institucion.nombre for institucion in instituciones" ng-model="institucion" ng-change="cargarDetalleInstitucion()">
                        <option value="">Seleccione Institución</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="detalle_institucion" class="control-label col-sm-3">{@ label_detalle @}</label>
                <div class="col-sm-9">
                  <div class="fg-line">
                    <div class="select">
                      <select name="detalle_institucion" id="detalle_institucion" class="form-control" ng-options="division.nombre_division for division in detalle" ng-model="detalle_institucion" ng-change="cargarMatriculas()">
                        <option value="">Seleccione {@ label_detalle @}</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>
              <table class="table table-bordered">
              <thead>
                <tr class="accent-color">
                  <td></td>
                  <td>Matrícula</td>
                  <td>Período</td>
                </tr>
                <tr class="search-row">
                  <th></th>
                  <th><input type="text" class="form-control table-input" placeholder="Buscar..." ng-model="busqueda.matricula"></th>
                  <th></th>
                </tr>
              </thead>
                <tr ng-repeat="matricula in matriculas | filter : { nombre : busqueda.matricula } : filtroMatricula">
                  <td>
                    <div class="checkbox table-checkbox">
                      <label>
                        <input type="checkbox" ng-model="matricula.seleccionada" value="{@ matricula.seleccionada @}" ng-change="actualizarMatriculas()">
                        <i class="input-helper"></i>
                      </label>
                    </div>
                  </td>
                  <td>{@ matricula.nombre @}</td>
                  <td>{@ matricula.periodo @}</td>
                </tr>
              </table>
            <div class="card-body card-padding">
              <div class="form-group m-t-15">
                <div class="col-sm-3 col-sm-offset-6">
                  <button class="btn btn-block btn-link waves-effect" type="button" ng-click="cancelar()"><i class="zmdi zmdi-close-circle-o"></i> Cancelar</button>
                </div>
                <div class="col-sm-3">
                  <button type="button" class="btn btn-block waves-effect accent-color" ng-click="cerrarCiclo()" ng-disabled="procesando || cantidad_matriculas == 0">
                    <span ng-hide="procesando"><i class="zmdi zmdi-assignment-check"></i> Cerrar Ciclo(s)</span>
                    <span ng-show="procesando">
                      <span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> Procesando...
                    </span>
                  </button>
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
  <script src="{{ asset('js/apps/ciclo.cerrar.js') }}"></script>
@endsection
