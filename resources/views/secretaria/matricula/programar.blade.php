@extends('layouts.dashboard')

@section('title')
  Programar Períodos
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

  <div class="row" ng-app="programarPeriodos">
    <div ng-controller="periodosController">
      <div class="col-sm-12">
        <div class="card hoverable">
          <div class="card-header main-color ch-alt">
            <h2>Programar Períodos</h2>
          </div>
          <div class="card-body card-padding">
            <form action="" class="form-horizontal">
              <div class="form-group">
                <label for="id_institucion" class="control-label col-sm-3">Institución</label>
                <div class="col-sm-9">
                  <div class="fg-line">
                    <div class="select">
                      <select name="id_institucion" id="id_institucion" class="form-control" ng-options="institucion.nombre for institucion in instituciones" ng-model="institucion" ng-change="cargarCategoriasTemp()">
                        <option value="">Seleccione Institución</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-hr"></div>
              <div class="row" ng-show="institucion">
                <div class="col-sm-12">
                  <div class="panel-group" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-collapse">
                      <div class="panel-heading" role="tab" id="headingOne">
                        <h4 class="panel-title">
                          <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                              Matrículas
                          </a>
                        </h4>
                      </div>
                      <div id="collapseOne" class="collapse in" role="tabpanel" aria-labelledby="headingOne">
                        <div class="panel-body">
                          <div class="collection">
                            <a href="#" class="collection-item" ng-repeat="matricula in matriculas_temp" ng-click="agregarMatricula(matricula, $index)">
                              <strong>{@ matricula.nombre_division @}:</strong> {@ matricula.concepto_matricula @}
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <table class="table table-bordered table-condensed">
                    <thead>
                      <tr class="text-center">
                        <td></td>
                        <td>
                          <div ng-hide="institucion.id_institucion == 3">Nivel</div>
                          <div ng-show="institucion.id_institucion == 3">Carrera</div>
                        </td>
                        <td>Concepto Matrícula</td>
                        <td>Fecha Inicial</td>
                        <td>Fecha Final</td>
                        <td>Mes Inicial Pensión</td>
                        <td>Mes Final Pensión</td>
                      </tr>
                    </thead>
                    <tbody>
                      <tr ng-repeat="matricula in matriculas_programar">
                        <td><button class="btn btn-danger btn-xs btn-ob-cancel" ng-click="quitar(matricula, $index)"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></td>
                        <td>{@ matricula.nombre_division @}</td>
                        <td>{@ matricula.concepto_matricula @}</td>
                        <td>
                          <p class="input-group">
                            <input type="text" class="form-control" datepicker-popup="dd/MM/yyyy" ng-model="matricula.fecha_inicial" is-open="matricula.opened1" datepicker-options="dateOptions1" current-text="Hoy" clear-text="Limpiar" close-text="Cerrar" show-button-bar="false" my-full-date/>
                            <span class="input-group-btn">
                              <button type="button" class="btn btn-default" ng-click="open($event,matricula,1)"><i class="glyphicon glyphicon-calendar"></i></button>
                            </span>
                          </p>
                        </td>
                        <td>
                          <p class="input-group">
                            <input type="text" class="form-control" datepicker-popup="dd/MM/yyyy" ng-model="matricula.fecha_final" is-open="matricula.opened2" datepicker-options="dateOptions1" current-text="Hoy" clear-text="Limpiar" close-text="Cerrar" show-button-bar="false" my-full-date/>
                            <span class="input-group-btn">
                              <button type="button" class="btn btn-default" ng-click="open($event,matricula,2)"><i class="glyphicon glyphicon-calendar"></i></button>
                            </span>
                          </p>
                        </td>
                        <td>
                          <p class="input-group">
                            <input type="text" class="form-control" datepicker-popup="MM/yyyy" ng-model="matricula.mes_inicial_pension" is-open="matricula.opened3" datepicker-options="dateOptions2" datepicker-mode="'month'" current-text="Hoy" clear-text="Limpiar" close-text="Cerrar" show-button-bar="false" my-month-date/>
                            <span class="input-group-btn">
                              <button type="button" class="btn btn-default" ng-click="open($event,matricula,3)"><i class="glyphicon glyphicon-calendar"></i></button>
                            </span>
                          </p>
                        </td>
                        <td>
                          <p class="input-group">
                            <input type="text" class="form-control" datepicker-popup="MM/yyyy" ng-model="matricula.mes_final_pension" is-open="matricula.opened4" datepicker-options="dateOptions2" datepicker-mode="'month'" current-text="Hoy" clear-text="Limpiar" close-text="Cerrar" show-button-bar="false" my-month-date/>
                            <span class="input-group-btn">
                              <button type="button" class="btn btn-default" ng-click="open($event,matricula,4)"><i class="glyphicon glyphicon-calendar"></i></button>
                            </span>
                          </p>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-3 col-sm-offset-9">
                  <button type="button" class="btn btn-block waves-effect m-t-15 accent-color" ng-click="crearMatriculaPensiones()" ng-disabled="procesando || cantidad_matriculas < 1">
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
  </div>
@endsection

@section('scripts')
  <script src="{{ asset('js/angular.min.js') }}"></script>
  <script src="{{ asset('js/angular-locale_es-es.js')}}"></script>
  <script src="{{ asset('js/ui-bootstrap-tpls-0.12.1.js')}}"></script>
  <script src="{{ asset('js/apps/periodos.programar.js') }}"></script>
@endsection
