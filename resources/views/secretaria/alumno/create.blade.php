@extends('layouts.dashboard')

@section('title')
  Nuevo Alumno
@endsection

@section('content')
  <h1>REGISTRAR ALUMNO</h1>

  @if(Session::has('message'))
    <div class="alert alert-success alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      {{Session::get('message')}}
    </div>
  @endif

  @include('messages.errors')

  <div class="row">
    <div class="col-md-8">
      <div class="card">
        <div class="card-body card-padding">
          {!!Form::open(array('route' => 'secretaria.alumnos.store', 'class' => 'form-horizontal', 'method' => 'POST'))!!}
            <div class="form-group">
              <label for="tipo_documento" class="col-sm-3 control-label">Tipo Documeno</label>
              <div class="col-sm-9">
                <select class="selectpicker" name="tipo_documento" id="tipo_documento" title='Seleccione'>
                  <option value="DNI">DNI</option>
                  <option value="PARTIDA DE NACIMIENTO">PARTIDA DE NACIMIENTO</option>
                  <option value="CARNET DE EXTRANJERIA">CARNET DE EXTRANJERIA</option>
                  <option value="OTRO">OTRO</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="dni" class="col-sm-3 control-label">Némero de Documento</label>
              <div class="col-sm-9">
                  <div class="fg-line">
                      <input type="text" class="form-control input-sm" id="nro_documento" name="nro_documento" placeholder="Documento de Alumno" >
                  </div>
              </div>
            </div>
            <div class="form-group">
              <label for="nombres" class="col-sm-3 control-label">Nombres</label>
              <div class="col-sm-9">
                  <div class="fg-line">
                      <input type="text" class="form-control input-sm" id="nombres" name="nombres" placeholder="Nombres">
                  </div>
              </div>
            </div>
            <div class="form-group">
              <label for="apellidos" class="col-sm-3 control-label">Apellidos</label>
              <div class="col-sm-9">
                  <div class="fg-line">
                      <input type="text" class="form-control input-sm" id="apellidos" name="apellidos" placeholder="Apellidos">
                  </div>
              </div>
            </div>
            <div class="form-group">
              <div class="pull-right">
                <button class="btn btn-warning waves-effect">Guardar</button>
              </div>
            </div>
          {!!Form::close()!!}
        </div>
      </div>
    </div>
  </div>
@endsection