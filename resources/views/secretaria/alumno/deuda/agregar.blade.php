@extends('layouts.dashboard')

@section('title')
  Agregar Deuda
@endsection

@section('content')
  <h1>AGREGAR DEUDA</h1>

  @if(Session::has('message'))
    <div class="alert alert-success alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      {{Session::get('message')}}
    </div>
  @endif

  @include('messages.errors')

  <div class="row">
    <div class="col-md-9">
      <div class="card">
        <div class="card-body card-padding">
          {!!Form::open(['class' => 'form-horizontal', 'id' => 'form-categorias-alumno'])!!}
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
        <div class="card">
          <div class="card-body card-padding">
            <h3 class="text-uppercase"><span id="nombre-alumno"></span></h3>
            {!!Form::open(['class' => 'form-horizontal', 'id' => 'form-agregar-deuda-alumno'])!!}
              <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
              <input type="hidden" name="nro_documento" id="nro_documento">
              <div class="form-group">
                <div class="table-responsive">
                  <table id="tabla-categorias-alumno" class="table table-striped">
                      <thead>
                          <tr>
                            <th class="hidden">Id</th>
                            <th class="danger c-white">Concepto</th>
                            <th class="danger c-white">Monto Unitario (S/)</th>
                            <th class="danger c-white">Factor</th>
                            <th class="danger c-white">Total (S/)</th>
                          </tr>
                      </thead>
                      <tbody>
                      </tbody>
                  </table>
                </div>
              </div>
              <div class="form-group">
                <div class="pull-right">
                  <button class="btn btn-warning waves-effect" id="btn-agregar-deuda">Guardar</button>
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