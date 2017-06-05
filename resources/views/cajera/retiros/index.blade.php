@extends('layouts.dashboard')

@section('title')
  Retiros
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

  <div ng-app="retirarIngresos" ng-controller="retirosCajeraController">
    <div class="row">
      <div class="col-md-12">
        <div class="card  hoverable">
          <div class="card-header main-color ch-alt">
            <h2>Retiros</h2>
          </div>
          <form class="form-horizontal" id="form-retiros">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
            <div class="table-responsive">
              <table class="table table-bordered" id="retiros">
                <thead>
                  <tr>
                    <th class="accent-color c-white">Fecha - Hora</th>
                    <th class="accent-color c-white">Usuario</th>
                    <th class="accent-color c-white">Monto (S/)</th>
                    <th class="accent-color c-white">Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($retiro as $ingreso)
                    <tr>
                      <td class="hidden">{{ $ingreso->id }}</td>
                      <td>{{ $ingreso->fecha_hora_creacion }}</td>
                      <td>{{ $ingreso->nombres . '  '.$ingreso->apellidos }}</td>
                      <td class="text-right">{{ number_format($ingreso->monto, 2) }}</td>
                      <td>
                        <div class="btn-group btn-group-sm" role="group">
                          <a href='#modal-confirmar-autorizacion' data-toggle='modal' class='btn third-color waves-effect' data-id="{{ $ingreso->id }}"><i class='zmdi zmdi-check'></i> Confirmar</a>
                          <a class='btn accent-color waves-effect' data-id="{{ $ingreso->id }}" ng-click="mostrarDetalleRetiro($event)"><i class='zmdi zmdi-more'></i> Detalle</a>
                        </div>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- Modal Detalle Retiro -->
    <div class="modal fade" id="modal-detalle-retiro" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Detalle de Retiro</h4>
          </div>
          <div class="modal-body">
            <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th class="accent-color c-white">Fecha</th>
                    <th class="accent-color c-white">Comprobante</th>
                    <th class="accent-color c-white">Concepto</th>
                    <th class="accent-color c-white">Monto</th>
                  </tr>
                </thead>
                <tbody>
                  <tr ng-repeat="item in retiro.detalle">
                    <td>{@ item.fecha_hora_ingreso @}</td>
                    <td>{@ item.documento @}</td>
                    <td>{@ item.nombre @}</td>
                    <td class="text-right">{@ item.monto | number:2 @}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="modal-footer">
            <a class="btn btn-link" data-dismiss="modal"><i class="zmdi zmdi-close-circle-o"></i> Cerrar</a>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal Detalle Retiro -->
  </div>
@endsection

@section('modals')
  @include('layouts.modals.confirmar')
@endsection

@section('scripts')
  <script src="{{ asset('js/cajera.js') }}"></script>
  <script src="{{ asset('js/angular.min.js') }}"></script>
  <script src="{{ asset('js/apps/retiros.administrar.js') }}"></script>
@endsection
