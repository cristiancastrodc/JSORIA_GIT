@extends('layouts.dashboard')

@section('title')
  Cobros
@endsection

@section('content')

  @if(Session::has('message'))
    <div class="row">
      <div class="col-sm-10">
        <div class="alert alert-success alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          {{ Session::get('message') }}
        </div>
      </div>
    </div>
  @endif

  @include('messages.errors')

  <div class="row" ng-app="registrarCobros">
    <div ng-controller="cobrosController">
      <div class="col-md-10">
        <div class="card hoverable">
          <div class="card-header main-color ch-alt">
            <h2>Cobros</h2>
          </div>
          <div class="card-body card-padding">
            <div ng-hide="hayResultados" class="animate-hide">
              <form class="form-horizontal">
                <div class="form-group">
                  <label for="codigo_cobro" class="control-label col-sm-3">Ingrese código:</label>
                  <div class="col-sm-9">
                    <div class="fg-line">
                      <input type="text" class="form-control" id="codigo_cobro" name="codigo_cobro" placeholder="DNI de alumno o Código de pago" ng-model="codigo_cobro">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-3 col-sm-offset-9">
                    <button class="btn btn-block accent-color waves-effect" type="button" ng-click="buscar()" ng-disabled="buscando">
                      <span ng-hide="buscando">Buscar</span>
                      <span ng-show="buscando">
                        <span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> Buscando...
                      </span>
                    </button>
                  </div>
                </div>
              </form>
            </div>
            <div ng-show="hayResultados" class="animate-hide">
              <form action="" class="form-horizontal">
                <div class="form-group">
                  <div class="col-sm-3 col-sm-offset-9">
                    <button class="btn btn-block btn-link waves-effect" type="button" ng-click="cancelar()">Cancelar</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script src="{{ asset('js/angular.min.js') }}"></script>
  <script src="{{ asset('js/apps/cobros.registrar.js') }}"></script>
@endsection
