@extends('layouts.dashboard')

@section('title')
  Administrar Otros Cobros
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

  <div ng-app="otrosCobros" ng-controller="crearOtroCobroController">
    <div class="row">
      <div class="col-md-6">
        <div class="card hoverable">
          <div class="card-header main-color ch-alt">
            <h2>Nuevo Cobro</h2>
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
                <label for="nombre" class="col-sm-3 control-label">Concepto</label>
                <div class="col-sm-9">
                  <div class="fg-line">
                    <input type="text" class="form-control input-sm" id="nombre" name="nombre" placeholder="Concepto" ng-model="nombre">
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
              <div class="form-group">
                <div class="col-sm-12">
                  <div class="toggle-switch">
                    <label for="habilitado" class="ts-label">Habilitado</label>
                    <input id="habilitado" name="habilitado" type="checkbox" hidden="hidden" ng-model="estado">
                    <label for="habilitado" class="ts-helper"></label>
                  </div>
                </div>
              </div>
              <div class="form-group m-t-15">
                <div class="col-md-5 col-md-offset-2">
                  <button class="btn btn-block btn-link waves-effect" type="button" ng-click="inicializar()"><i class="zmdi zmdi-close-circle-o"></i> Cancelar</button>
                </div>
                <div class="col-sm-5">
                  <button type="button" class="btn btn-block waves-effect  accent-color" ng-click="guardarOtroCobro()" ng-disabled="procesando || !esValidoFormCreacion()">
                    <span ng-hide="procesando"><i class="zmdi zmdi-assignment-check"></i> Guardar</span>
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
            <h2>Lista de Otros Cobros</h2>
          </div>
          <div class="card-body card-padding">
            <form class="form-horizontal" id="form-listar-c-otros">
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
                  <button class="btn btn-link btn-block" ng-click="inicializarFormBusqueda()"><i class="zmdi zmdi-close-circle-o"></i> Cancelar</button>
                </div>
                <div class="col-sm-4">
                  <button class="btn btn-block accent-color waves-effect" ng-click="listarOtrosCobros()" ng-disabled="form_busqueda.procesando">
                    <span ng-hide="form_busqueda.procesando"><i class="zmdi zmdi-search"></i> Buscar</span>
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
                  <th class="accent-color c-white">Concepto</th>
                  <th class="accent-color c-white">Monto</th>
                  <th class="accent-color c-white">Estado</th>
                  <th class="accent-color c-white">Acciones</th>
                </tr>
                <tr class="search-row">
                  <th><input type="text" class="form-control table-input" placeholder="Buscar..." ng-model="busqueda.concepto"></th>
                  <th></th>
                  <th></th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <tr ng-repeat="cobro in cobros | filter : { nombre : busqueda.concepto } : filtroConcepto">
                  <td>{@ cobro.nombre @} <br> {@ cobro.institucion @}</td>
                  <td>{@ cobro.monto @}</td>
                  <td>{@ cobro.estado == 0 ? 'Inhabilitado' : 'Habilitado' @}</td>
                  <td>
                    <div class="btn-group btn-group-sm" role="group">
                      <a class="btn third-color" data-toggle="tooltip" data-placement="top" data-original-title="Modificar" tooltip ng-click="editarCobro(cobro)"><i class="zmdi zmdi-edit"></i></a>
                      <a class='btn fourth-color waves-effect' ng-click="eliminarCobro(cobro.id)" data-toggle="tooltip" data-placement="top" data-original-title="Eliminar" tooltip><i class='zmdi zmdi-delete'></i></a>
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
            <h4 class="modal-title">Editar Cobro</h4>
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
                <label for="modal_nombre" class="col-sm-3 control-label">Concepto:</label>
                <div class="col-sm-9">
                  <div class="fg-line">
                    <input type="text" class="form-control" id="modal_nombre" ng-model="modal.nombre" placeholder="Concepto">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="modal-monto" class="col-sm-3 control-label">Monto:</label>
                <div class="col-sm-9">
                  <div class="fg-line">
                    <input type="text" class="form-control input-sm" id="modal-monto" ng-model="modal.monto" placeholder="Monto">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="modal-estado" class="col-sm-3 control-label">Habilitado:</label>
                <div class="col-sm-9">
                  <div class="toggle-switch">
                    <label for="modal-estado" class="ts-label"></label>
                    <input id="modal-estado" ng-model="modal.estado" type="checkbox" hidden="hidden">
                    <label for="modal-estado" class="ts-helper"></label>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <div class="col-sm-4 col-sm-offset-4">
              <a class="btn btn-link btn-block waves-effect" data-dismiss="modal"><i class="zmdi zmdi-close-circle-o"></i>  Cerrar</a>
            </div>
            <div class="col-sm-4">
              <button class="btn btn-block accent-color waves-effect" ng-click="actualizarCobro()" ng-disabled="modal.procesando || !esValidoFormEdicion()">
                <span ng-hide="modal.procesando"><i class="zmdi zmdi-assignment-check"></i> Guardar</span>
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
  <script src="{{ asset('js/apps/cobros.otros.administrar.js') }}"></script>
@endsection
