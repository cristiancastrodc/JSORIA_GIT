@extends('layouts.dashboard')

@section('title')
  Crear Matrícula
@endsection

@section('content')
  @if(Session::has('message'))
  <div class="row">
    <div class="col-sm-12">
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
      <div class="col-sm-10">
        <div class="card hoverable">
          <div class="card-header main-color ch-alt">
            <h2>Crear Matrícula</h2>
          </div>
          <div class="card-body card-padding">
            <form action="" class="form-horizontal">
              <div class="form-group">
                <label for="id_institucion" class="control-label col-sm-3">Institución</label>
                <div class="col-sm-9">
                  <select name="id_institucion" id="id_institucion" class="selectpicker" title="Seleccione" ng-model="id_institucion" ng-change="recuperarDetalle()">
                    <option value="">Seleccione</option>
                    <option value="1">I.E. J. Soria</option>
                    <option value="2">CEBA Konrad Adenauer</option>
                    <option value="3">I.S.T. Urusayhua</option>
                    <option value="4">Universidad Privada Líder Peruana</option>
                  </select>
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
              <div class="card-hr"></div>
              <table class="table table-bordered">
                <tr class="accent-color">
                  <td>Nivel / Carrera</td>
                  <td>Monto Matrícula</td>
                  <td>Monto Pensiones</td>
                </tr>
                <tr ng-repeat="detalle in divisiones">
                  <td>{@ detalle.nombre_division @}</td>
                  <td>
                    <input type="text" class="form-control text-right" value="{@ detalle.monto_matricula @}" ng-model="detalle.monto_matricula">
                  </td>
                  <td class="text-right">
                    <input type="text" class="form-control text-right" value="{@ detalle.monto_pensiones @}" ng-model="detalle.monto_pensiones">
                  </td>
                </tr>
              </table>
              <div class="form-group">
                <div class="col-sm-3 col-sm-offset-9">
                  <button type="button" class="btn btn-block waves-effect m-t-15 accent-color" ng-click="crearMatriculaPensiones()" ng-disabled="procesando">
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
  <script src="{{ asset('js/apps/matricula.crear.js') }}"></script>
@endsection
