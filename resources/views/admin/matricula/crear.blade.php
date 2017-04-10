@extends('layouts.dashboard')

@section('title')
  Crear Matrícula
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

  <div class="row" ng-app="crearMatricula">
    <div ng-controller="matriculaController">
      <div class="col-sm-12">
        <div class="card hoverable">
          <div class="card-header main-color ch-alt">
            <h2>Crear Matrícula</h2>
          </div>
          <form action="" class="form-horizontal">
            <div class="card-body card-padding">            
              <div class="form-group">
                <label for="id_institucion" class="control-label col-sm-3">Institución</label>
                <div class="col-sm-9">
                  <div class="fg-line">
                    <div class="select">
                      <select class="form-control" id="id_institucion" ng-options="institucion.nombre for institucion in instituciones" ng-model="institucion" ng-change="recuperarDetalle()">
                        <option value="" disabled="">-- SELECCIONE INSTITUCIÓN --</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="periodo" class="control-label col-sm-3">Período:</label>
                <div class="col-sm-9">
                  <div class="fg-line">
                    <input type="text" id="periodo" name="periodo" class="form-control" placeholder="Ingrese el período. Ejemplo: 2016 - I." ng-model="periodo">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="definir_fechas" class="control-label col-sm-3">Definir Fechas:</label>
                <div class="col-sm-9">
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" id="definir_fechas" name="definir_fechas" ng-model="definir_fechas">
                      <i class="input-helper"></i>
                      Marque esta opción si desea definir las fechas para la matrícula y las pensiones. En caso contrario, estas fechas serán definidas por el usuario Secretaria.
                    </label>
                  </div>
                </div>
              </div>
              <div class="card-hr"></div>
              <h4>Datos de Matrícula</h4>
              <div class="form-group">
                <label for="concepto" class="control-label col-sm-3">Concepto</label>
                <div class="col-sm-9">
                  <div class="fg-line">
                    <div class="dtp-container fg-line">
                      <input type="text" id="concepto" name="concepto" class="form-control" placeholder="Concepto" ng-model="matricula.concepto">
                    </div>
                  </div>
                </div>
              </div>
              <div ng-show="definir_fechas">
                <div class="form-group">
                  <label for="fecha_inicio_matricula" class="col-sm-3 control-label">Fecha Inicio</label>
                  <div class="col-sm-9">
                    <div class="fg-line">
                      <div class="dtp-container fg-line">
                        <input type='text' class="form-control date-picker" placeholder="Fecha Inicial" name="fecha_inicio_matricula" id="fecha_inicio_matricula" ng-model="matricula.fecha_inicio">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="fecha_fin_matricula" class="col-sm-3 control-label">Fecha Fin</label>
                  <div class="col-sm-9">
                    <div class="fg-line">
                      <div class="dtp-container fg-line">
                        <input type='text' class="form-control date-picker" placeholder="Fecha Final" name="fecha_fin_matricula" id="fecha_fin_matricula" ng-model="matricula.fecha_fin">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-hr"></div>
              <h4>Datos de Pensiones</h4>
              <div class="form-group">
                <label for="concepto_pensiones" class="control-label col-sm-3">Concepto</label>
                <div class="col-sm-9">
                  <div class="fg-line">
                    <div class="dtp-container fg-line">
                      <input type="text" id="concepto_pensiones" name="concepto_pensiones" class="form-control" placeholder="Concepto" ng-model="pensiones.concepto">
                    </div>
                  </div>
                </div>
              </div>
              <div ng-show="definir_fechas">
                <div class="form-group">
                  <label for="mes_inicio_pension" class="col-sm-3 control-label">Mes Inicial</label>
                  <div class="col-sm-9">
                    <div class="fg-line">
                      <div class="dtp-container fg-line">
                        <input type='text' class="form-control month-picker" placeholder="Mes Inicial" name="mes_inicio_pension" id="mes_inicio_pension" ng-model="pensiones.mes_inicio">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="mes_fin_pension" class="col-sm-3 control-label">Mes Final</label>
                  <div class="col-sm-9">
                    <div class="fg-line">
                      <div class="dtp-container fg-line">
                        <input type='text' class="form-control month-picker" placeholder="Mes Final" name="mes_fin_pension" id="mes_fin_pension" ng-model="pensiones.mes_fin">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-hr"></div>
            </div>
              <table class="table table-bordered">
                <tr class="accent-color">
                  <td></td>
                  <td>Nivel / Carrera</td>
                  <td>Monto Matrícula</td>
                  <td>Monto Pensiones</td>
                  <td ng-show="id_institucion == 3 && !definir_fechas"></td>
                </tr>
                <tr ng-repeat="detalle in divisiones">
                  <td>
                    <div class="checkbox table-checkbox">
                      <label>
                        <input type="checkbox" ng-model="detalle.seleccionar" value="{@ detalle.seleccionar @}">
                        <i class="input-helper"></i>
                      </label>
                    </div>
                  </td>
                  <td>{@ detalle.nombre_division @}</td>
                  <td>
                    <input type="number" class="form-control table-input text-right" ng-model="detalle.monto_matricula" ng-disabled="!detalle.seleccionar" placeholder="Monto">
                  </td>
                  <td class="text-right">
                    <input type="number" class="form-control table-input text-right" ng-model="detalle.monto_pensiones" ng-disabled="!detalle.seleccionar" placeholder="Monto">
                  </td>
                  <td ng-show="institucion.id_institucion == 3 && !definir_fechas">
                    <div class="checkbox table-checkbox">
                      <label>
                        <input type="checkbox" ng-model="detalle.crear_ingresantes" value="{@ detalle.crear_ingresantes @}" ng-disabled="!detalle.seleccionar">
                        <i class="input-helper"></i>
                        Crear conceptos para 1er Semestre.
                      </label>
                    </div>
                  </td>
                </tr>
              </table>
            <div class="card-body card-padding">      
              <div class="form-group m-t-15">
                <div class="col-md-4 col-md-offset-4">
                  <button class="btn btn-block btn-link waves-effect" type="button" ng-click="cancelar()">Cancelar</button>
                </div>
                <div class="col-sm-4">
                  <button type="button" class="btn btn-block waves-effect accent-color" ng-click="crearMatriculaPensiones()" ng-disabled="procesando">
                    <span ng-hide="procesando">Guardar</span>
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
  <script src="{{ asset('js/apps/matricula.crear.js') }}"></script>
@endsection
