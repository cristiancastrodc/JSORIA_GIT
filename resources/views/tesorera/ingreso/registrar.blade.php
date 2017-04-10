@extends('layouts.dashboard')

@section('title')
  Retirar Ingresos Adicionales
@endsection

@section('content')

  @if(Session::has('message'))
    <div class="row">
      <div class="col-sm-10">
        <div class="alert alert-success alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          {{Session::get('message')}}
        </div>
      </div>
    </div>
  @endif

  @include('messages.errors')

  <div class="row" ng-app="registrarIngresoAdicional">
    <div ng-controller="registrarIngresoController">
      <div class="col-md-10">
        <div class="card hoverable">
          <div class="card-header main-color ch-alt">
            <h2>Registrar Ingresos Adicionales</h2>
          </div>
          <div class="card-body card-padding">
            <form action="{{ url('tesorera/registrar/ingresos/guardar') }}" class="form-horizontal" method="POST">
            <input type="hidden" value="{{ csrf_token() }}" name="_token">
              <div class="form-group">
                <label for="id_institucion" class="control-label col-sm-3">Institución</label>
                <div class="col-sm-9">
                     <div class="fg-line">
                      <div class="select">
                        <select class="form-control" id="id_institucion" ng-options="institucion.id_institucion as institucion.nombre for institucion in instituciones" ng-model="institucion">
                          <option value="" disabled="">-- SELECCIONE INSTITUCIÓN --</option>
                        </select>
                      </div>
                    </div>
                  </div>
              </div>
              <input type="hidden" value="{@ institucion @}" name="id_institucion">
              <div class="form-group">
                <label for="monto" class="control-label col-sm-3">Monto</label>
                <div class="col-sm-9">
                  <div class="fg-line">
                    <input type="number" name="monto" id="monto" class="form-control" ng-model="monto">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-5 col-md-offset-2">
                  <button class="btn btn-block btn-link waves-effect" type="button" ng-click="inicializar()">Cancelar</button>
                </div>
                <div class="col-sm-5">
                  <button type="submit" class="btn btn-block main-color waves-effect">Guardar</button>
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
  <script src="{{ asset('js/apps/registrar.ingresos.js') }}"></script>
@endsection
