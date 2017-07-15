@extends('layouts.dashboard')

@section('title', 'Editar Matrícula')

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

  <div class="row" ng-app="editarMatricula">
    <div ng-controller="matriculaController">
      <div class="col-sm-12">
        <div class="card hoverable">
          <div class="card-header main-color ch-alt">
            <h2>Editar Matrícula</h2>
          </div>
          <form class="form-horizontal">
            <div class="card-body card-padding">
              <div class="form-group">
                <label for="institucion" class="control-label col-sm-3">Institución</label>
                <div class="col-sm-9">
                  <div class="fg-line">
                    <div class="select">
                      <select name="institucion" id="institucion" class="form-control" ng-options="institucion.id_institucion as institucion.nombre for institucion in instituciones" ng-model="id_institucion" ng-change="cargarDetalleInstitucion()">
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
                      <select name="detalle_institucion" id="detalle_institucion" class="form-control" ng-options="division.id as division.nombre_division for division in detalle" ng-model="id_detalle_institucion" ng-change="cargarMatriculas()">
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
                      <select name="matricula" id="matricula" class="form-control" ng-options="matricula.nombre for matricula in matriculas" ng-model="matricula" ng-change="cargarPensiones()">
                        <option value="">Seleccione Matrícula</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div ng-show="matricula.id">
                <div class="form-group">
                  <label for="fecha_inicio_matricula" class="col-sm-3 control-label">Fecha Inicio</label>
                  <div class="col-sm-9">
                    <div class="fg-line">
                      <div class="dtp-container fg-line">
                        <input type='text' class="form-control date-picker" placeholder="Fecha Inicial" name="fecha_inicio_matricula" id="fecha_inicio_matricula" ng-model="matricula.fecha_inicio" datepicker>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="fecha_fin_matricula" class="col-sm-3 control-label">Fecha Fin</label>
                  <div class="col-sm-9">
                    <div class="fg-line">
                      <div class="dtp-container fg-line">
                        <input type='text' class="form-control date-picker" placeholder="Fecha Final" name="fecha_fin_matricula" id="fecha_fin_matricula" ng-model="matricula.fecha_fin" datepicker>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="periodo" class="control-label col-sm-3">Período:</label>
                  <div class="col-sm-9">
                    <div class="fg-line">
                      <input type="text" id="periodo" name="periodo" class="form-control" placeholder="Ingrese el período. Ejemplo: 2016 - I." ng-model="matricula.periodo">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="estado" class="control-label col-sm-3">Habilitar:</label>
                  <div class="col-sm-9">
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" id="estado" name="estado" ng-model="matricula.estado">
                        <i class="input-helper"></i>
                        Marque esta opción si desea habilitar la matrícula.
                      </label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <table class="table table-bordered">
              <thead>
                <tr class="accent-color">
                  <td></td>
                  <td>Concepto</td>
                  <td>Monto</td>
                </tr>
                <tr class="search-row">
                  <th></th>
                  <th><input type="text" class="form-control table-input" placeholder="Buscar..." ng-model="busqueda.concepto"></th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <tr ng-repeat="pension in pensiones | filter : { nombre : busqueda.concepto } : filtroConcepto">
                  <td>
                    <div class="checkbox table-checkbox">
                      <label>
                        <input type="checkbox" ng-model="pension.seleccionada" value="{@ pension.seleccionada @}">
                        <i class="input-helper"></i>
                      </label>
                    </div>
                  </td>
                  <td>
                    <input type="text" value="{@ pension.nombre @}" ng-model="pension.nombre" class="form-control table-input" ng-disabled="!pension.seleccionada">
                  </td>
                  <td class="text-right">
                    <input type="number" ng-model="pension.monto" class="form-control table-input text-right" ng-disabled="!pension.seleccionada" step="0.01" string-to-number>
                  </td>
                </tr>
              </tbody>
            </table>
            <div class="card-body card-padding">
              <div class="form-group">
                <div class="col-sm-3 col-sm-offset-6">
                  <button class="btn btn-block btn-link waves-effect" type="button" ng-click="cancelar()"><i class="zmdi zmdi-close-circle-o"></i> Cancelar</button>
                </div>
                <div class="col-sm-3">
                  <button type="button" class="btn btn-block waves-effect accent-color" ng-click="guardarCambios()" ng-disabled="procesando">
                    <span ng-hide="procesando"><i class="zmdi zmdi-assignment-check"></i> Guardar</span>
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
  <script src="{{ asset('js/apps/directives.js') }}"></script>
  <script src="{{ asset('js/apps/matricula.editar.js') }}"></script>
@endsection
