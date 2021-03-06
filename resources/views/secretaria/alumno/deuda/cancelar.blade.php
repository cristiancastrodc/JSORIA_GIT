@extends('layouts.dashboard')

@section('title')
  Cancelar deuda de actividad
@endsection

@section('content')
  <h1>CANCELAR DEUDA DE ACTIVIDAD</h1>

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
          {!!Form::open(['class' => 'form-horizontal', 'id' => 'form-buscar-actividades-alumno'])!!}
            <div class="form-group">
              <label for="dni" class="col-sm-3 control-label">Alumno</label>
              <div class="col-sm-9">
                  <div class="fg-line">
                      <input type="text" class="form-control input-sm" id="nro_documento" name="nro_documento" placeholder="Documento de Alumno">
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
                          <th class="danger c-white">Concepto</th>
                          <th class="danger c-white">Monto (S/)</th>
                          <th class="danger c-white">seleccionar</th>
                        </tr>
                    </thead>
                    <tbody>                      
                    </tbody>
                </table>
              </div>                
            </div>  
            <div class="form-group">
              <div class="pull-right">
                <button class="btn btn-warning waves-effect" id="btn-cancelar-deuda-actividad">Cancelar Deudas</button>
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