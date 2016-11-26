@extends('layouts.dashboard')

@section('title')
  Reporte de Deudas de Alumno
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

  <div class="row">
    <div class="col-md-10">
      <div class="card hoverable">
        <div class="card-header main-color ch-alt">
          <h2>Reporte De Deudas de Alumno</h2>
        </div>
        <div class="card-body card-padding">
          <form action="{{ url('/admin/reportes/deudas_alumno/procesar') }}" class="form-horizontal" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <div class="form-group">
                <label for="nro_documento" class="control-label col-sm-3">Alumno</label>
                <div class="col-sm-9">
                  <div class="fg-line">
                    <input type="text" class="form-control" id="nro_documento" name="nro_documento" placeholder="DNI o Código del alumno">
                  </div>
                </div>
              </div>
              <!-- EXCEL O PDF -->
              <div class="form-group">
                <label for="tipo_reporte" class="control-label col-sm-3">Tipo de Reporte</label>
                <div class="col-sm-9">
                  <div class="radio">
                    <label>
                        <input type="radio" name="tipo_reporte" value="pdf" checked="checked">
                        <i class="input-helper"></i>PDF
                    </label>
                  </div>
                  <div class="radio">
                    <label>
                        <input type="radio" name="tipo_reporte" value="excel">
                        <i class="input-helper"></i>Excel
                    </label>
                  </div>
                </div>
              </div>
              <!--/ EXCEL O PDF -->
              <div class="form-group">
                <div class="col-sm-3 col-sm-offset-9">
                  <button type="submit" class="btn btn-block waves-effect m-t-15 accent-color" formtarget="_blank">Generar</button>
                </div>
              </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
