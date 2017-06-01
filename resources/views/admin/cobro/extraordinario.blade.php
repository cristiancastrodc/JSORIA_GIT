@extends('layouts.dashboard')

@section('title')
  Administrar Cobros Extraordinarios
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

  <div ng-app="cobrosExtraordinarios" ng-controller="crearCobroExtraordinarioController">
    <div class="row">
      <div class="col-md-6">
        <div class="card hoverable">
          <div class="card-header main-color ch-alt">
            <h2>Crear Cobro Extraordinario</h2>
          </div>
          <div class="card-body card-padding">
            <form class="form-horizontal">
              <div class="form-group">
                <label for="id_institucion" class="col-sm-3 control-label">Institución</label>
                <div class="col-sm-9">
                   <div class="fg-line">
                    <div class="select">
                      <select class="form-control" id="institucion" ng-options="institucion.nombre for institucion in instituciones" ng-model="institucion">
                        <option value="" disabled="">-- SELECCIONE INSTITUCIÓN --</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="descripcion_extr" class="col-sm-3 control-label">Descripción:</label>
                <div class="col-sm-9">
                  <div class="fg-line">
                    <textarea class="form-control" rows="2" placeholder="Escriba la descripcion" name="descripcion_extr" ng-model="descripcion_extr"></textarea>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="monto" class="col-sm-3 control-label">Monto</label>
                <div class="col-sm-9">
                  <div class="fg-line">
                    <input type="number" class="form-control input-sm" id="monto" name="monto" placeholder="Monto" ng-model="monto">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="cliente_extr" class="col-sm-3 control-label">Cliente:</label>
                <div class="col-sm-9">
                  <div class="fg-line">
                    <input type="text" class="form-control input-sm" id="cliente_extr" name="cliente_extr" placeholder="Ingrese el nombre del cliente" ng-model="cliente_extr">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-12">
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" name="exterior" ng-model="destino">
                      <i class="input-helper"></i>
                      Cuenta exterior privada
                      <p><small> Marque esta casilla para almacenar los ingresos por ese concepto en la cuenta exterior privada de la corporación</small></p>
                    </label>
                  </div>
                </div>
              </div>
              <div class="form-group m-t-15">
                <div class="col-md-5 col-md-offset-2">
                  <button class="btn btn-block btn-link waves-effect" type="button" ng-click="inicializar()">Cancelar</button>
                </div>
                <div class="col-sm-5">
                  <button type="button" class="btn btn-block waves-effect accent-color" ng-click="guardarCobroExtraordinario()" ng-disabled="procesando">
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
      <div class="col-md-6">
        <div class="card hoverable">
          <div class="card-header main-color ch-alt">
            <h2>Listar Cobros Extraordinarios</h2>
          </div>
          <div class="card-body card-padding">
            <form class="form-horizontal">
              <div class="form-group">
                <label for="form_busqueda_institucion" class="col-sm-3 control-label">Institución</label>
                <div class="col-sm-9">
                  <div class="fg-line">
                    <div class="select">
                      <select class="form-control" id="form_busqueda_institucion" ng-options="institucion.id_institucion as institucion.nombre for institucion in instituciones" ng-model="form_busqueda.id_institucion">
                        <option value="">-- SELECCIONE INSTITUCIÓN --</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-4 col-sm-offset-4">
                  <button class="btn btn-link btn-block" ng-click="inicializarFormBusqueda()">Cancelar</button>
                </div>
                <div class="col-sm-4">
                  <button class="btn btn-block accent-color waves-effect" ng-click="listarCobrosExtraordinarios()" ng-disabled="form_busqueda.procesando">
                    <span ng-hide="form_busqueda.procesando">Buscar</span>
                    <span ng-show="form_busqueda.procesando">
                      <span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> Buscando...
                    </span>
                  </button>
                </div>
              </div>
            </form>
          </div>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th class="accent-color c-white">Código</th>
                  <th class="accent-color c-white">Concepto</th>
                  <th class="accent-color c-white">Monto</th>
                  <th class="accent-color c-white">Estado</th>
                  <th class="accent-color c-white">Acciones</th>
                </tr>
              </thead>
              <tbody>
                <tr ng-repeat="cobro in cobros">
                  <td>{@ cobro.id @}</td>
                  <td>{@ cobro.descripcion_extr @}</td>
                  <td class="text-right">{@ cobro.saldo | number:2 @}</td>
                  <td>{@ cobro.estado_pago == 0 ? 'Pendiente' : 'Cancelado' @}</td>
                  <td>
                    <div ng-show="cobro.estado_pago == 0">
                      <div class="btn-group btn-group-sm" role="group">
                        <a class="btn third-color" data-toggle="tooltip" data-placement="top" data-original-title="Modificar" tooltip ng-click="editarCobro(cobro)"><i class="zmdi zmdi-edit"></i></a>
                        <a class='btn fourth-color waves-effect' ng-click="eliminarCobro(cobro.id)" data-toggle="tooltip" data-placement="top" data-original-title="Anular" tooltip><i class='zmdi zmdi-delete'></i></a>
                      </div>
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
    <div class="modal fade" id="modal-editar-cobro" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Editar Cobro Extraordinario</h4>
          </div>
          <div class="modal-body">
            <div id="modal-error" ng-show="modal.errores">
              <div class="alert alert-danger" role="alert">
                <ul><li ng-repeat="(key, value) in modal.errores">{@ value[0] @}</li></ul>
              </div>
            </div>
            <form class="form-horizontal">
              <div class="form-group">
                <label for="modal_institucion" class="control-label col-sm-3">Institución:</label>
                <div class="col-sm-9">
                  <div class="fg-line">
                    <p class="form-control-static">{@ modal.institucion @}</p>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="modal_descripcion" class="col-sm-3 control-label">Descripción:</label>
                <div class="col-sm-9">
                  <div class="fg-line">
                    <input type="text" class="form-control" id="modal_descripcion" ng-model="modal.descripcion_extr" placeholder="Descripción">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="modal_cliente" class="col-sm-3 control-label">Cliente:</label>
                <div class="col-sm-9">
                  <div class="fg-line">
                    <input type="text" class="form-control" id="modal_cliente" ng-model="modal.cliente_extr" placeholder="Cliente">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="modal_monto" class="col-sm-3 control-label">Monto:</label>
                <div class="col-sm-9">
                  <div class="fg-line">
                    <input type="text" class="form-control" id="modal_monto" ng-model="modal.monto" placeholder="Monto">
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <div class="col-sm-4 col-sm-offset-4">
              <a class="btn btn-link btn-block waves-effect" data-dismiss="modal">Cerrar</a>
            </div>
            <div class="col-sm-4">
              <button class="btn btn-block accent-color waves-effect" ng-click="actualizarCobro()" ng-disabled="modal.procesando || !esValidoFormEdicion()">
                <span ng-hide="modal.procesando">Guardar</span>
                <span ng-show="modal.procesando">
                  <span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> Procesando...
                </span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /Modal -->
  </div>
@endsection

@section('scripts')
  <script src="{{ asset('js/angular.min.js') }}"></script>
  <script src="{{ asset('js/apps/cobros.extraordinarios.administrar.js') }}"></script>
@endsection
