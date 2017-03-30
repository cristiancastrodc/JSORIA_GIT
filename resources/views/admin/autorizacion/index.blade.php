@extends('layouts.dashboard')

@section('title')
  Autorización Descuento Mediante Resolución
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

  <div ng-app="autorizarDescuentos" ng-controller="descuentosController">
    <div class="row">
      <div class="col-md-6">
        <div class="card hoverable">
          <div class="card-header main-color ch-alt">
            <h2>Autorizar Descuento</h2>
          </div>
          <div class="card-body card-padding">
            <form class="form-horizontal">
              <div ng-class="clase_documento">
                <label for="nro_documento" class="col-sm-3 control-label">Documento del Alumno</label>
                <div class="col-sm-9">
                  <div class="fg-line">
                    <input type="text" class="form-control" id="nro_documento" placeholder="Ingrese DNI o Código de alumno" ng-model="nro_documento" ng-blur="buscarAlumno()">
                  </div>
                  <small class="help-block" ng-hide="existe_alumno">Código de alumno no registrado.</small>
                </div>
              </div>
              <div class="form-group">
                <label for="datos_alumno" class="col-sm-3 control-label">Alumno</label>
                <div class="col-sm-9">
                  <div class="fg-line">
                    <textarea class="form-control" id="datos_alumno" name="datos_alumno" ng-model="datos_alumno" disabled="" rows="3"></textarea>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="resolucion" class="col-sm-3 control-label">Resolucion</label>
                <div class="col-sm-9">
                  <div class="fg-line">
                    <input type="text" class="form-control input-sm" id="resolucion" name="resolucion" placeholder="Numero de RD" ng-model="resolucion">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="fecha_limite" class="col-sm-3 control-label">Fecha Limite</label>
                <div class="col-sm-9">
                  <div class="dtp-container fg-line">
                    <input type='text' class="form-control date-picker" placeholder="Fecha" name="fecha_limite" id="fecha_limite" autocomplete="off" ng-model="fecha_limite">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-6 col-sm-offset-6">
                  <button type="button" class="btn btn-block waves-effect m-t-15 accent-color" ng-click="guardarAutorizacion()" ng-disabled="procesando || !(datos_alumno && resolucion)">
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
            <h2>Listar Autorizaciones</h2>
          </div>
          <div class="card-body card-padding">
            <form class="form-horizontal" id="form-listar-autorizaciones">
              <div class="form-group">
                <label for="busqueda_nro_documento" class="col-sm-3 control-label">Documento:</label>
                <div class="col-sm-9">
                  <div class="fg-line">
                    <input type="text" class="form-control" id="busqueda_nro_documento" placeholder="DNI o Código de alumno" ng-model="form_busqueda.nro_documento">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="busqueda_fecha_creacion" class="col-sm-3 control-label">Fecha Creación:</label>
                <div class="col-sm-9">
                  <div class="dtp-container fg-line">
                    <input type='text' class="form-control date-picker" placeholder="Fecha Creación" id="busqueda_fecha_creacion" ng-model="form.fecha_creacion">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-4 col-sm-offset-8">
                  <button type="button" class="btn btn-block accent-color waves-effect" ng-click="buscarAutorizacion()" ng-disabled="form_busqueda.procesando">
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
                  <th class="accent-color c-white">Resolución</th>
                  <th class="accent-color c-white">Alumno</th>
                  <th class="accent-color c-white">Acciones</th>
                </tr>
              </thead>
              <tbody>
                <tr ng-repeat="autorizacion in autorizaciones">
                  <td>{@ autorizacion.rd @}</td>
                  <td>{@ autorizacion.id_alumno @}</td>
                  <td><a class='btn third-color m-r-20' ng-click="mostrarDetalle(autorizacion)" ><i class='zmdi zmdi-more'></i></a></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modal-detalle-autorizacion" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Datos de la Autorización</h4>
          </div>
          <div class="modal-body">
            <form class="form-horizontal">
              <div class="form-group">
                <label for="modal_resolucion" class="control-label col-sm-4">Resolución</label>
                <div class="col-sm-8">
                  <div class="fg-line">
                    <p class="form-control-static">{@ modal.resolucion @}</p>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="modal_id_alumno" class="control-label col-sm-4">Documento Alumno:</label>
                <div class="col-sm-8">
                  <div class="fg-line">
                    <p class="form-control-static">{@ modal.id_alumno @}</p>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="modal_nombre_alumno" class="control-label col-sm-4">Alumno:</label>
                <div class="col-sm-8">
                  <div class="fg-line">
                    <p class="form-control-static">{@ modal.nombre_alumno @}</p>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="modal_fecha_limite" class="control-label col-sm-4">Fecha Límite:</label>
                <div class="col-sm-8">
                  <div class="fg-line">
                    <p class="form-control-static">{@ modal.fecha_limite | date:'dd/MM/yyyy' @}</p>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="modal_fecha_creacion" class="control-label col-sm-4">Fecha Creación:</label>
                <div class="col-sm-8">
                  <div class="fg-line">
                    <p class="form-control-static">{@ modal.fecha_creacion @}</p>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="modal_estado" class="control-label col-sm-4">Estado:</label>
                <div class="col-sm-8">
                  <div class="fg-line">
                    <p class="form-control-static">{@ modal.estado @}</p>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-4 col-md-offset-4">
                  <a class="btn btn-link" data-dismiss="modal">Cerrar</a>
                </div>
                <div class="col-md-4">
                  <button class="btn btn-block fourth-color waves-effect" type="button" ng-disabled="!modal.puede_eliminar" ng-click="eliminarAutorizacion(modal.id_autorizacion)"><i class="zmdi zmdi-delete"></i> Eliminar</button>
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
  <script src="{{ asset('js/apps/descuentos.administrar.js') }}"></script>
@endsection
