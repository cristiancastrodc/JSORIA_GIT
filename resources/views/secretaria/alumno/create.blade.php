@extends('layouts.dashboard')

@section('title')
  Nuevo Alumno
@endsection

@section('content')
  @if(Session::has('message'))
    <div class="row">
      <div class="col-sm-10">
        <div class="alert alert-{{ Session::get('message-class') }} alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
          </button>
          {{ Session::get('message') }}
        </div>
      </div>
    </div>
  @endif

  @include('messages.errors')

  <div ng-app="nuevoAlumno" ng-controller="alumnoNuevoController">
    <div class="row">
      <div class="col-md-12">
        <div class="card hoverable">
          <div class="card-header main-color ch-alt">
            <h2>Nuevo Alumno</h2>
          </div>
          <div class="card-body card-padding">
            {!!Form::open(array('route' => 'secretaria.alumnos.store', 'class' => 'form-horizontal', 'method' => 'POST'))!!}
              <div class="form-group">
                <label for="tipo_documento" class="col-sm-3 control-label">Tipo Documento</label>
                <div class="col-sm-9">
                  <select class="selectpicker" name="tipo_documento" id="tipo_documento" title='Seleccione Tipo de Documento' ng-model = 'tipo_documento'>
                    <option value="" disabled="">Seleccione Tipo de Documento</option>
                    <option value="DNI">DNI</option>
                    <option value="PARTIDA DE NACIMIENTO">CODIGO DE ESTUDIANTE</option>
                    <option value="CARNET DE EXTRANJERIA">CARNET DE EXTRANJERIA</option>
                    <option value="OTRO">OTRO</option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="dni" class="col-sm-3 control-label">Número de Documento</label>
                <div class="col-sm-9">
                    <div class="fg-line">
                        <input type="text" class="form-control input-sm" id="nro_documento" name="nro_documento" placeholder="Documento de Alumno" ng-model = 'nro_documento'>
                    </div>
                </div>
              </div>
              <div class="form-group">
                <label for="nombres" class="col-sm-3 control-label">Nombres</label>
                <div class="col-sm-9">
                    <div class="fg-line">
                        <input type="text" class="form-control input-sm" id="nombres" name="nombres" placeholder="Nombres" ng-model = 'nombres'>
                    </div>
                </div>
              </div>
              <div class="form-group">
                <label for="apellidos" class="col-sm-3 control-label">Apellidos</label>
                <div class="col-sm-9">
                    <div class="fg-line">
                        <input type="text" class="form-control input-sm" id="apellidos" name="apellidos" placeholder="Apellidos" ng-model = 'apellidos'>
                    </div>
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-4 col-md-offset-4 m-t-10">
                  <button class="btn btn-block btn-link waves-effect" type="button" ng-click="inicializar()"><i class="zmdi zmdi-close-circle-o"></i> Cancelar</button>
                </div>
                <div class="col-sm-4">               
                  <button type="submit" class="btn btn-block accent-color waves-effect m-t-10" ng-disabled="!esValidoFormCreacion()"><i class="zmdi zmdi-assignment-check"></i> Guardar</button>
                </div>              
              </div>
            {!!Form::close()!!}
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('scripts')
  <script src="{{ asset('js/angular.min.js') }}"></script>
  <script src="{{ asset('js/apps/alumno.nuevo.js') }}"></script>
@endsection