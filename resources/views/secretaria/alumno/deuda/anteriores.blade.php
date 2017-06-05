@extends('layouts.dashboard')

@section('title')
  Agregar Deudas Anteriores de Alumno
@endsection

@section('content')

  @if(Session::has('message'))
    <div class="row">
      <div class="col-sm-10">
        <div class="alert alert-success alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          {{Session::get('message')}}
        </div>
      </div>
    </div>
  @endif

  @include('messages.errors')

  <div class="row" ng-app="agregarDeudasAlumno">
    <div ng-controller="deudasController">
      <div class="col-md-10">
        <div class="card hoverable">
          <div class="card-header main-color ch-alt">
            <h2>Agregar Deudas Anteriores de Alumno</h2>
          </div>
          <div class="card-body card-padding">
            <form class="form-horizontal">
              <div ng-hide="matriculando">
                <div class="form-group">
                  <label for="codigo_alumno" class="control-label col-sm-3">Alumno</label>
                  <div class="col-sm-9">
                    <div class="fg-line">
                      <input type="text" class="form-control" id="codigo_alumno" name="codigo_alumno" placeholder="DNI o Código del alumno" ng-model="alumno.nro_documento">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-3 col-sm-offset-9">
                    <button class="btn btn-block accent-color waves-effect" type="button" ng-click="buscar()" ng-disabled="buscando">
                      <span ng-hide="buscando"><i class="zmdi zmdi-search"></i> Buscar</span>
                      <span ng-show="buscando">
                        <span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> Buscando...
                      </span>
                    </button>
                  </div>
                </div>
              </div>
              <div ng-show="matriculando">
                <h3 class="text-uppercase m-t-0">{@ alumno.nombres @} {@ alumno.apellidos @}</h3>
                <h4 class="text-uppercase m-t-0">{@ datosinstitucion.institucion @} {@ datosinstitucion.division @} {@ datosinstitucion.grado @}</h4>
                <div class="form-group">
                  <label for="id_institucion" class="control-label col-sm-3">Institución</label>
                  <div class="col-sm-9">
                    <div class="fg-line">
                      <div class="select">
                        <select name="id_institucion" id="id_institucion" class="form-control" ng-options="institucion.nombre for institucion in instituciones" ng-model="institucion" ng-change="cargarDetalle()">
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
                <div class="form-group">
                  <label for="matricula" class="control-label col-sm-3">Matrícula</label>
                  <div class="col-sm-9">
                    <div class="fg-line">
                      <div class="select">
                        <select name="matricula" id="matricula" class="form-control" ng-options="matricula.nombre for matricula in matriculas" ng-model="matricula" ng-change="cargarPensiones($index)">
                          <option value="">Seleccione Matrícula</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                <table class="table table-bordered">
                  <tr class="accent-color">
                    <td></td>
                    <td>Concepto</td>
                    <td>Período</td>
                    <td>Deuda</td>
                  </tr>
                  <tr ng-repeat="pension in pensiones">
                    <td>
                      <div class="checkbox table-checkbox">
                        <label>
                          <input type="checkbox" ng-model="pension.seleccionada" value="{@ pension.seleccionada @}" ng-change="contarCategorias()">
                          <i class="input-helper"></i>
                        </label>
                      </div>
                    </td>
                    <td>{@ pension.nombre @}</td>
                    <td>{@ pension.periodo @}</td>
                    <td class="text-right">
                      <input type="number" value="{@ pension.monto @}" ng-model="pension.monto" class="form-control table-input text-right" ng-disabled="!pension.seleccionada">
                    </td>
                  </tr>
                </table>
                <div class="form-group m-t-15">
                  <div class="col-sm-3 col-sm-offset-6">
                    <button class="btn btn-block btn-link waves-effect" type="button" ng-click="cancelar()"><i class="zmdi zmdi-close-circle-o"></i> Cancelar</button>
                  </div>
                  <div class="col-sm-3">
                    <button type="button" class="btn btn-block waves-effect accent-color" ng-click="crearMatricula()" ng-disabled="procesando || cantidad_categorias == 0">
                      <span ng-hide="procesando"><i class="zmdi zmdi-assignment-check"></i> Agregar Deudas</span>
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
  </div>
@endsection

@section('scripts')
  <script src="{{ asset('js/angular.min.js') }}"></script>
  <script src="{{ asset('js/apps/alumno.deudas.anteriores.js') }}"></script>
@endsection