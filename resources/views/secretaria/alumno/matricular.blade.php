@extends('layouts.dashboard')

@section('title')
  Crear Cuenta de Alumno
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

  <div class="row" ng-app="matricularAlumno">
    <div ng-controller="matriculaController">
      <div class="col-md-10">
        <div class="card hoverable">
          <div class="card-header main-color ch-alt">
            <h2>Matricular Alumno</h2>
          </div>
          <div class="card-body card-padding">
            <div ng-hide="hayResultados" class="animate-hide">
              <form class="form-horizontal">
                <div class="form-group">
                  <label for="codigo_alumno" class="control-label col-sm-3">Alumno:</label>
                  <div class="col-sm-9">
                    <div class="fg-line">
                      <input type="text" class="form-control" id="codigo_alumno" name="codigo_alumno" placeholder="DNI o Código del alumno" ng-model="codigo_alumno">
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
          </div>         
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script src="{{ asset('js/angular.min.js') }}"></script>
  <script src="{{ asset('js/apps/matricular.alumno.js') }}"></script>
@endsection