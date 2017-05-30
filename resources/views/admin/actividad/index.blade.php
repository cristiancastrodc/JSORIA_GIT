@extends('layouts.dashboard')

@section('title')
  Administrar Actividades
@endsection

@section('content')
  @if(Session::has('message'))
    <div class="row">
      <div class="col-sm-12">
        <div class="alert alert-success alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          {{Session::get('message')}}
        </div>
      </div>
    </div>
  @endif

  @include('messages.errors')

  <div ng-app="administrarActividades" ng-controller="actividadesController">
    <div class="row">
      <div class="col-md-6">
        <div class="card hoverable">
          <div class="card-header main-color ch-alt">
            <h2>Crear Actividad</h2>
          </div>
          <div class="card-body card-padding">
            <form class="form-horizontal">
              <div class="form-group">
                <label for="institucion" class="col-sm-3 control-label">Institución</label>
                <div class="col-sm-9">
                  <div class="fg-line">
                    <div class="select">
                      <select class="form-control" id="institucion" ng-options="institucion.nombre for institucion in instituciones" ng-model="actividad.institucion" ng-change="cargarDetalle()" ng-disabled="actividad.todas_instituciones">
                        <option value="" disabled="">-- SELECCIONE INSTITUCIÓN --</option>
                      </select>
                    </div>
                  </div>
                  <!-- div class="checkbox">
                    <label>
                      <input type="checkbox" id="todas_instituciones" ng-model="actividad.todas_instituciones">
                      <i class="input-helper"></i>
                      Todas las instituciones
                    </label>
                  </div-->
                </div>
              </div>
              <div class="form-group">
                <label for="division" class="control-label col-sm-3">{@ labels.division @}</label>
                <div class="col-sm-9">
                  <div class="fg-line">
                    <div class="select">
                      <select class="form-control" id="division" ng-options="division.nombre_division for division in divisiones" ng-model="actividad.division" ng-disabled="actividad.todas_instituciones || actividad.todas_divisiones">
                        <option value="">-- Seleccione {@ labels.division @} --</option>
                      </select>
                    </div>
                  </div>
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" id="todas_divisiones" ng-model="actividad.todas_divisiones" ng-disabled="!actividad.institucion">
                      <i class="input-helper"></i>
                      {@ labels.todas_divisiones @}
                    </label>
                  </div>
                </div>
              </div>
              <div class="form-group">
                  <label for="nombre" class="col-sm-3 control-label">Nombre</label>
                  <div class="col-sm-9">
                    <div class="fg-line">
                        <input type="text" class="form-control" id="nombre" placeholder="Nombre de la Actividad" ng-model="actividad.nombre">
                    </div>
                  </div>
              </div>
              <div class="form-group">
                  <label for="monto" class="col-sm-3 control-label">Monto</label>
                  <div class="col-sm-9">
                    <div class="input-group">
                        <span class="input-group-addon">S/</span>
                        <div class="fg-line">
                          <input type="number" class="form-control" id="monto" placeholder="Monto de la Actividad" ng-model="actividad.monto">
                        </div>
                    </div>
                  </div>
              </div>
              <div class="form-group">
                <div class="col-md-4 col-md-offset-4">
                  <button class="btn btn-block btn-link waves-effect" type="button" ng-click="inicializar()">Cancelar</button>
                </div>
                <div class="col-sm-4">
                  <button type="button" class="btn btn-block accent-color waves-effect" ng-click="grabarActividad()" ng-disabled="procesando || !esValidoFormCreacion()">
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
      <div class="col-md-6">
        <div class="card hoverable">
          <div class="card-header main-color ch-alt">
            <h2>Buscar Actividades</h2>
          </div>
          <div class="card-header">
            <form class="form-horizontal" id="form-listar-actividades">
              <div class="form-group">
                <label for="form_busqueda_institucion" class="col-sm-3 control-label">Institución</label>
                <div class="col-sm-9">
                  <div class="fg-line">
                    <div class="select">
                      <select class="form-control" id="form_busqueda_institucion" ng-options="institucion.id_institucion as institucion.nombre for institucion in instituciones" ng-model="form_busqueda.institucion" ng-change="cargarDetalleFormBusqueda()">
                        <option value="" disabled="">-- SELECCIONE INSTITUCIÓN --</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="form_busqueda_division" class="control-label col-sm-3">{@ labels.form_busqueda_division @}</label>
                <div class="col-sm-9">
                  <div class="fg-line">
                    <div class="select">
                      <select class="form-control" id="form_busqueda_division" ng-options="division.id as division.nombre_division for division in form_busqueda.divisiones" ng-model="form_busqueda.division">
                        <option value="">-- Seleccione {@ labels.form_busqueda_division @} --</option>
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
                  <button class="btn btn-block accent-color waves-effect" ng-click="listarActividades()" ng-disabled="form_busqueda.procesando">
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
            <table id="tabla-listar-actividades" class="table table-striped">
              <thead>
                <tr>
                  <th class="c-white accent-color">Actividad</th>
                  <th class="c-white accent-color">Monto</th>
                  <th class="c-white accent-color">Acciones</th>
                </tr>
              </thead>
              <tbody>
                <tr ng-repeat="actividad in actividades">
                  <td>{@ actividad.nombre @} <br> {@ actividad.institucion @} </td>
                  <td>{@ actividad.monto @}</td>
                  <td>
                    <a class='btn third-color' ng-click="editarActividad(actividad)"><i class='zmdi zmdi-edit'></i></a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modal-editar-actividad" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Editar Actividad</h4>
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
                <label for="modal-nombre" class="control-label col-sm-3">Nombre:</label>
                <div class="col-sm-9">
                  <div class="fg-line">
                    <input type="text" name="nombre" id="modal-nombre" class="form-control" ng-model="modal.nombre">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="modal-monto" class="control-label col-sm-3">Monto:</label>
                <div class="col-sm-9">
                  <div class="fg-line">
                    <input type="text" id="modal-monto" name="modal-monto" class="form-control" ng-model="modal.monto">
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
              <button class="btn btn-block accent-color waves-effect" ng-click="actualizarActividad()" ng-disabled="modal.procesando || !esValidoFormEdicion()">
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
  <script src="{{ asset('vendors/bootstrap-growl/bootstrap-growl.min.js') }}"></script>
  <script src="{{ asset('js/admin.js') }}"></script>
  <script src="{{ asset('js/angular.min.js') }}"></script>
  <script src="{{ asset('js/apps/actividades.administrar.js') }}"></script>
@endsection
