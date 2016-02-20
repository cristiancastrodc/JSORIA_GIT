@extends('layouts.dashboard')

@section('title')
  Crear Cuenta de Alumno
@endsection

@section('content')
  <h1>CREAR CUENTA DE ALUMNO</h1>

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
          {!!Form::open(['class' => 'form-horizontal', 'id' => 'form-buscar-alumno'])!!}
            <div class="form-group">
              <label for="nro_documento" class="col-sm-3 control-label">Alumno</label>
              <div class="col-sm-9">
                  <div class="fg-line">
                    @if (session('nro_documento'))
                      <input type="text" class="form-control input-sm" id="nro_documento" name="nro_documento" placeholder="Documento Alumno" autocomplete="off" value="{{ session('nro_documento') }}">
                    @else
                      <input type="text" class="form-control input-sm" id="nro_documento" name="nro_documento" placeholder="Documento Alumno" autocomplete="off">
                    @endif
                  </div>
              </div>
            </div>
            <div class="form-group">
              <div class="pull-right">
                <button class="btn btn-warning waves-effect" id="btn-buscar-alumno">Buscar</button>
              </div>
            </div>
          {!!Form::close()!!}
        </div>
      </div>
      <div class="card js-toggle">
        <div class="card-header">
          <h3><span id="nombre-alumno"></span></h3>
        </div>
        <div class="card-body card-padding">
          {!!Form::open(['class' => 'form-horizontal', 'id' => 'form-matricular'])!!}
            <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
            <input type="hidden" name="nro_documento" id="nro_documento">
            <div class="form-group">
              <label for="id_institucion" class="col-sm-3 control-label">Institución</label>
              <div class="col-sm-9">
                <select class="selectpicker" name="id_institucion" id="id_institucion" title='Elegir...'>
                  @foreach($permisos as $permiso)
                    <option value="{{ $permiso->id }}">{{$permiso->nombre}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-9 col-sm-offset-3">
                <select class="selectpicker" name="id_detalle_institucion" id="id_detalle_institucion" title='Elegir...'>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="id_institucion" class="col-sm-3 control-label">Tipo Matricula</label>
              <div class="col-sm-9">
                <select class="selectpicker" name="id_tipo_matricula" id="id_tipo_matricula" title='Elegir...'>
                  <option >Normal</option>
                  <option >Becado</option>
                  <option >Convenio</option>
                </select>
              </div>
            </div>            
            <div class="form-group">
              <div class="pull-right">
                <div class="col-sm-12">
                  <button class="btn btn-warning waves-effect" id="btn-matricular">Matricular</button>
                </div>
              </div>
            </div>
          {!!Form::close()!!}
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script src="{{ asset('js/secretaria.js') }}"></script>
@endsection