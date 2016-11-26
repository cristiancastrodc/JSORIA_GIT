@extends('layouts.dashboard')

@section('title')
  Reporte de Lista de Ingresos por Cajera
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
          <h2>Reporte De Lista de Ingresos por Cajera</h2>
        </div>
        <div class="card-body card-padding">
          <form action="{{ url('/admin/reportes/ingresos_cajera/procesar') }}" class="form-horizontal" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
              <label for="id_cajera" class="col-sm-3 control-label">Seleccionar cajera:</label>
              <div class="col-sm-9 text-uppercase">
                <select class="selectpicker" name="id_cajera" id="id_cajera" title='Seleccione'>
                  @foreach ($cajeras as $cajera)
                    <option value="{{ $cajera->id }}">{{ $cajera->nombres }} {{ $cajera->apellidos }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="fecha" class="col-sm-3 control-label">Fecha:</label>
              <div class="col-sm-9">
                <div class="fg-line">
                  <div class="dtp-container fg-line">
                    <input type='text' class="form-control date-picker" placeholder="Fecha" name="fecha" id="fecha"   autocomplete="off">
                  </div>
                </div>
              </div>
            </div>
            <!-- EXCEL O PDF -->
            <div class="form-group">
              <label for="tipo_reporte" class="control-label col-sm-3">Tipo de Reporte</label>
              <div class="col-sm-9">
                <div class="radio">
                  <label>
                      <input type="radio" name="tipo_reporte" value="pdf">
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
