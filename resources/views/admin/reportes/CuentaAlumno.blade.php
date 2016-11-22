@extends('layouts.dashboard')

@section('title')
  Reporte de Cuenta de Alumno
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
    <div class="col-md-8">
      <div class="card hoverable">
        <div class="card-header main-color ch-alt">
          <h2>Reporte de Cuenta de Alumno</h2>
        </div>
        <div class="card-body card-padding" >
          <form action="{{ url('/admin/reportes/CuentaAlumno/procesar') }}" class="form-horizontal" method="POST">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
              <label for="nro_documento" class="col-sm-3 control-label">Alumno</label>
              <div class="col-sm-9">
                  <div class="fg-line">
                      <input type="text" class="form-control input-sm" id="nro_documento" name="nro_documento" placeholder="Documento Alumno" autocomplete="off">
                  </div>
              </div>
            </div>            
            <div class="form-group">
              <div class="pull-right">
                <button type="submit" class="btn btn-warning waves-effect" id="btn-buscar-alumno" formtarget="_blank">Generar</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script src="{{ asset('js/reportes.js') }}"></script>
@endsection