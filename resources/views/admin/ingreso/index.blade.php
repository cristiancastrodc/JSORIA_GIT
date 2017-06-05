@extends('layouts.dashboard')

@section('title')
  Retirar Ingresos
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

  <div ng-app="retirarIngresos" ng-controller="retirosController">
    <div class="row">
      <div class="col-md-6">
        <div class="card hoverable">
          <div class="card-header main-color ch-alt">
            <h2>Retirar Ingresos</h2>
          </div>
          <div class="card-body card-padding">
            <form class="form-horizontal" id="form-ingresos-cajera">
              <div class="form-group">
                <label for="id_institucion" class="col-sm-3 control-label">Cajera:</label>
                <div class="col-sm-9">
                  <select class="selectpicker text-uppercase" name="id_cajera" id="id_cajera" title='Seleccione Cajera'>
                    <option value="" disabled="">-- Seleccione Cajera --</option>
                    @foreach ($cajeras as $cajera)
                      <option value="{{ $cajera->id }}">{{ $cajera->nombres }} {{ $cajera->apellidos }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-4 col-sm-offset-8">
                  <button class="btn btn-block accent-color waves-effect" id="btn-ingresos-cajera"><i class="zmdi zmdi-search"></i> Buscar</button>
                </div>
              </div>
            </form>
          </div>
          <form class="form-horizontal hidden" id="form-detalle-retiro">
            <input type="hidden" value="{{ csrf_token() }}" id="_token">
            <input type="hidden" id="id_cajera_retirar">
            <div class="table-responsive">
              <table class="table table-bordered table-condensed" id="tabla-ingresos-cajera">
                <thead>
                  <tr>
                    <th class="hidden">Id</th>
                    <th class="bgm-blue-soria c-white">Fecha</th>
                    <th class="bgm-blue-soria c-white">Comprobante</th>
                    <th class="bgm-blue-soria c-white">Concepto</th>
                    <th class="bgm-blue-soria c-white x2">Estado</th>
                    <th class="bgm-blue-soria c-white">Monto</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot class="text-right bgm-orange c-white">
                  <tr>
                    <td colspan="4">TOTAL NO RETIRADO (S/)</td>
                    <td id="cobros-no-retirados"></td>
                  </tr>
                  <tr>
                    <td colspan="4">TOTAL POR RETIRAR (S/)</td>
                    <td id="cobros-por-retirar"></td>
                  </tr>
                </tfoot>
              </table>
            </div>
            <div class="card-body card-padding">
              <div class="form-group">
                <div class="col-sm-4 col-sm-offset-4">
                  <button class="btn btn-block btn-link waves-effect" type="button" ng-click="inicializar()"><i class="zmdi zmdi-close-circle-o"></i> Cancelar</button>
                </div>
                <div class="col-sm-4">
                  <button class="btn btn-block waves-effect accent-color" id="btn-retirar-ingresos"><i class="zmdi zmdi-assignment-check"></i> Retirar</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card hoverable">
          <div class="card-header main-color ch-alt">
            <h2>Listar Retiros</h2>
          </div>
          <div class="card-body card-padding">
            <div class="form-horizontal">
              <div class="form-group m-b-0">
                <div class="col-md-12">
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" id="retiros_pendientes" name="retiros_pendientes" ng-model="retiros_pendientes" ng-true-value="1" ng-false-value="0">
                      <i class="input-helper"></i>
                      Mostrar sólo retiros pendientes.
                    </label>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th class="accent-color c-white">Fecha Creación</th>
                  <th class="accent-color c-white">Cajera</th>
                  <th class="accent-color c-white">Monto</th>
                  <th class="accent-color c-white">Acciones</th>
                </tr>
              </thead>
              <tbody>
                <tr ng-repeat="retiro in retiros | filter : filtrarRetiros ">
                  <td>{@ retiro.fecha_hora_creacion @}</td>
                  <td>{@ retiro.apellidos @} {@ retiro.nombres @}</td>
                  <td class="text-right">{@ retiro.monto | number : 2 @}</td>
                  <td>
                    <div class="btn-group btn-group-sm" role="group">
                      <a class="btn third-color waves-effect" ng-click="mostrarDetalle(retiro)" data-toggle="tooltip" data-placement="top" data-original-title="Ver Detalle" tooltip><i class='zmdi zmdi-more'></i></a>
                      <a class="btn fourth-color waves-effect" ng-click="eliminarRetiro(retiro.id)" data-toggle="tooltip" data-placement="top" data-original-title="Eliminar" tooltip ng-show="retiro.estado == 0"><i class='zmdi zmdi-delete'></i></a>
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
    <div class="modal fade" id="modal-detalle-retiro" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Datos del Retiro</h4>
          </div>
          <div class="modal-body">
            <form class="form-horizontal">
              <div class="form-group">
                <label for="modal_monto" class="control-label col-sm-4">Monto:</label>
                <div class="col-sm-8">
                  <div class="fg-line">
                    <p class="form-control-static">{@ modal.monto | number : 2 @}</p>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="modal_fecha_hora_creacion" class="control-label col-sm-4">Fecha Creación:</label>
                <div class="col-sm-8">
                  <div class="fg-line">
                    <p class="form-control-static">{@ modal.fecha_hora_creacion @}</p>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="modal_cajera" class="control-label col-sm-4">Cajera:</label>
                <div class="col-sm-8">
                  <div class="fg-line">
                    <p class="form-control-static text-uppercase">{@ modal.cajera @}</p>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="modal_fecha_limite" class="control-label col-sm-4">Fecha Retiro:</label>
                <div class="col-sm-8">
                  <div class="fg-line">
                    <p class="form-control-static">{@ modal.fecha_hora_retiro @}</p>
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
                <div class="col-md-4 col-md-offset-8">
                  <a class="btn btn-link btn-block" data-dismiss="modal"><i class="zmdi zmdi-close-circle-o"></i> Cerrar</a>
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
  <script src="{{ asset('js/admin.js') }}"></script>
  <script src="{{ asset('js/angular.min.js') }}"></script>
  <script src="{{ asset('js/apps/retiros.administrar.js') }}"></script>
@endsection
