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
              <div class="form-group m-t-15">
                <div class="col-md-4 col-md-offset-4">
                  <button class="btn btn-block btn-link waves-effect" type="button" ng-click="inicializar()">Cancelar</button>
                </div>
                <div class="col-sm-4">
                  <button type="button" class="btn btn-block waves-effect accent-color" ng-click="guardarComprobante()" ng-disabled="procesando">
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
                  <th class="c-white accent-color">Acciones</th>
                </tr>
              </thead>
              <tbody>
                <tr ng-repeat="comprobante in comprobantes">
                  <td>{@ comprobante.institucion @}</td>
                  <td class="text-capitalize">{@ comprobante.tipo @}</td>
                  <td>{@ comprobante.serie @}</td>
                  <td>{@ comprobante.numero_comprobante @}</td>
                  <td>
                    <div class="btn-group btn-group-sm" role="group">
                      <a class='btn third-color waves-effect' ng-click="editarComprobante(comprobante)" ><i class='zmdi zmdi-edit'></i></a>
                      <a class='btn fourth-color waves-effect' ng-click="confirmarEliminacion(comprobante.id)" ><i class='zmdi zmdi-delete'></i></a>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modal-detalle-comprobante" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Editar Comprobante</h4>
          </div>
          <div class="modal-body">
            <form class="form-horizontal">
              <div class="form-group">
                <label for="modal_comprobante_institucion" class="control-label col-sm-4">Institución:</label>
                <div class="col-sm-8">
                  <div class="fg-line">
                    <p class="form-control-static">{@ modal.comprobante.institucion @}</p>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="modal_comprobante_tipo" class="control-label col-sm-4">Tipo:</label>
                <div class="col-sm-8">
                  <div class="fg-line">
                    <p class="form-control-static text-capitalize">{@ modal.comprobante.tipo @}</p>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="modal_comprobante_serie" class="control-label col-sm-4">Serie:</label>
                <div class="col-sm-8">
                  <div class="fg-line">
                    <input type="text" class="form-control" id="modal_comprobante_serie" ng-model="modal.comprobante.serie">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="modal_comprobante_numero" class="control-label col-sm-4">Número:</label>
                <div class="col-sm-8">
                  <div class="fg-line">
                    <input type="text" class="form-control" id="modal_comprobante_numero" ng-model="modal.comprobante.numero_comprobante">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-4 col-md-offset-4">
                  <a class="btn btn-link btn-block waves-effect" data-dismiss="modal">Cerrar</a>
                </div>
                <div class="col-md-4">
                  <button class="btn btn-block accent-color waves-effect" type="button" ng-click="actualizarComprobante()" ng-disabled="modal.procesando">
                    <span ng-hide="modal.procesando">Grabar</span>
                    <span ng-show="modal.procesando">
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
  <script src="{{ asset('js/apps/comprobantes.administrar.js') }}"></script>
@endsection
