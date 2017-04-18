@extends('layouts.dashboard')

@section('title')
  Deudas de Alumno
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
          <h2>Deudas</h2>
        </div>
        <div class="card-body card-padding">
          {!!Form::open(['class' => 'form-horizontal', 'id' => 'form-buscar-deudas-alumno'])!!}
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
        <div class="card hoverable">
          <div class="card-header">
            <h3 class="text-uppercase"><span id="nombre-alumno"></span></h3>
            <h4><span id="institucion-alumno"></span></h4>
          </div>
            {!!Form::open(['class' => 'form-horizontal', 'id' => 'form-lista-deudas-alumno'])!!}
              <div class="card-body card-padding">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
                <input type="hidden" name="nro_documento" id="nro_documento">
              </div>
              <div class="table-responsive">
                <table id="tabla-deudas-alumno" class="table table-striped">
                    <thead>
                        <tr>
                          <th class="hidden">Id</th>
                          <th class="accent-color c-white">Deuda</th>
                          <th class="accent-color c-white">Monto (S/)</th>
                          <th class="accent-color c-white">Descuento (S/)</th>
                          <th class="accent-color c-white">¿Anular?</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
              </div>              
            {!!Form::close()!!}
        </div>
      </div>
      <div class="card js-toggle">
        <div class="card hoverable">
          <div class="card-body card-padding">
            {!!Form::open(['class' => 'form-horizontal', 'id' => 'form-autorizacion-descuento'])!!}
              <div class="form-group">
                <label for="" class="control-label col-sm-3">Resolucion:</label>
                <div class="col-sm-9">
                  <div class="fg-line">
                    <input type="text" name="rd" id="rd" class="form-control" placeholder="Número de Resolucion">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-3 col-sm-offset-9">
                  <button class="btn btn-block accent-color waves-effect m-t-10" id="btn-autorizar-descuento">Guardar</button>
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
  <script src="{{ asset('js/secretaria.js') }}"></script>
@endsection