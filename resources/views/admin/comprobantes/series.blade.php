@extends('layouts.dashboard')

@section('title')
  Definir Comprobantes
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
<div ng-app="administrarComprobantes" ng-controller="comprobantesController">
  <div class="row">
    <div class="col-sm-6">
      <div class="card hoverable">
        <div class="card-header main-color ch-alt">
          <h2>Definir Comprobantes</h2>
        </div>
        <div class="card-body card-padding">
          <form class="form-horizontal">
            <div class="form-group">
              <label for="tipo_comprobante" class="control-label col-sm-3">Tipo:</label>
              <div class="col-sm-9">
                <select class="selectpicker" id="tipo_comprobante" ng-model="comprobante.tipo" ng-options="tipo as tipo.label for tipo in tipos_comprobante">
                  <option value="" disabled="">-- Seleccione Tipo de Comprobante --</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="serie_comprobante" class="control-label col-sm-3">Serie</label>
              <div class="col-sm-9">
                <div class="fg-line">
                  <input type="text" id="serie_comprobante" class="form-control" placeholder="Serie" ng-model="comprobante.serie">
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="numero_comprobante" class="control-label col-sm-3">Número</label>
              <div class="col-sm-9">
                <div class="fg-line">
                  <input type="text" id="numero_comprobante" class="form-control" placeholder="Número actual" ng-model="comprobante.numero">
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="id_institucion" class="control-label col-sm-3">Institución</label>
              <div class="col-sm-9">
                <div class="fg-line">
                  <div class="select">
                    <select class="form-control" id="institucion_comprobante" ng-options="institucion.nombre for institucion in instituciones" ng-model="comprobante.institucion">
                      <option value="" disabled="">-- SELECCIONE INSTITUCIÓN --</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-4 col-sm-offset-8">
                <button type="button" class="btn btn-block waves-effect m-t-15 accent-color" ng-click="guardarComprobante()" ng-disabled="procesando">
                  <span ng-hide="procesando">Grabar</span>
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
    <div class="col-sm-6">
      <div class="card hoverable">
        <div class="card-header main-color ch-alt">
          <h2>Comprobantes</h2>
        </div>
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th class="c-white accent-color">Institución</th>
                <th class="c-white accent-color">Tipo</th>
                <th class="c-white accent-color">Serie</th>
                <th class="c-white accent-color">Número</th>
              </tr>
            </thead>
            <tbody>
              <tr ng-repeat="comprobante in comprobantes">
                <td>{@ comprobante.nombre @}</td>
                <td>{@ comprobante.tipo @}</td>
                <td>{@ comprobante.serie @}</td>
                <td>{@ comprobante.numero_comprobante @}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
  <script src="{{ asset('js/angular.min.js') }}"></script>
  <script src="{{ asset('js/apps/comprobantes.administrar.js') }}"></script>
@endsection
