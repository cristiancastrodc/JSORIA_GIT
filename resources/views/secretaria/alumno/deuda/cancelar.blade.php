@extends('layouts.dashboard')

@section('title')
  Cancelar deuda de actividad
@endsection

@section('content')
  @if(Session::has('message'))
    <div class="alert alert-success alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      {{Session::get('message')}}
    </div>
  @endif

  @include('messages.errors')

  <div class="row">
    <div class="col-md-10">
      <div class="card hoverable">
        <div class="card-header main-color ch-alt">
          <h2>Cancelar Deuda de Actividad</h2>
        </div>
        <div class="card-body card-padding">
          {!!Form::open(['class' => 'form-horizontal', 'id' => 'form-buscar-actividades-alumno'])!!}
            <div class="form-group">
              <label for="dni" class="col-sm-3 control-label">Alumno</label>
              <div class="col-sm-9">
                  <div class="fg-line">
                      <input type="text" class="form-control input-sm" id="nro_documento" name="nro_documento" placeholder="Ingrese DNI o Código del Alumno">
                  </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-3 col-sm-offset-9">
                <button class="btn btn-block accent-color waves-effect m-t-10" id="btn-buscar-alumno">Buscar</button>
              </div>
            </div>
          {!!Form::close()!!}
        </div>
      </div>
      <div class="card js-toggle">
        <div class="card-header">
          <h3><span id="nombre-alumno" class="text-uppercase"></span></h3>
        </div>
        <div class="card-body card-padding">
          {!!Form::open(['class' => 'form-horizontal', 'id' => 'form-lista-deudas-alumno'])!!}
            <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
            <input type="hidden" name="nro_documento" id="nro_documento">
            <div class="form-group">
              <div class="table-responsive">
                <table id="tabla-actividades-listar-alumno" class="table table-striped">
                    <thead>
                        <tr>
                          <th class="hidden">Id</th>
                          <th class="accent-color c-white">Concepto</th>
                          <th class="accent-color c-white">Monto (S/)</th>
                          <th class="accent-color c-white">seleccionar</th>
                        </tr>
                    </thead>
                    <tbody>                      
                    </tbody>
                </table>
              </div>                
            </div>  
            <div class="form-group">
              <div class="col-sm-3 col-sm-offset-9">
                <button class="btn btn-block accent-color waves-effect m-t-10" id="btn-cancelar-deuda-actividad">Cancelar Deudas</button>
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