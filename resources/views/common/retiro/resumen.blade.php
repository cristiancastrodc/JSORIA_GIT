@extends('layouts.dashboard')

@section('title')
  Resumen de Creación del Retiro
@endsection

@section('content')

  @if(Session::has('message'))
  <div class="row">
    <div class="col-sm-12">
      <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        {{ Session::get('message') }}
      </div>
    </div>
  </div>
  @endif

  @include('messages.errors')

  <div class="row">
    <div class="col-md-12">
      <div class="card hoverable">
        <div class="card-header main-color ch-alt">
          <h2>Resumen de Creación del Retiro</h2>
        </div>
        <div class="card-body card-padding">
          <div class="alert alert-success" role="alert">
            Retiro creado correctamente.
          </div>
        </div>
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th class="accent-color c-white">Fecha Ingreso</th>
                <th class="accent-color c-white">Concepto</th>
                <th class="accent-color c-white">Monto</th>
                <th class="accent-color c-white">Documento</th>
              </tr>
            </thead>
            <tbody>
              @foreach($cobros as $cobro)
                <tr>
                  <td>{{ $cobro->fecha_hora_ingreso }}</td>
                  <td>{{ $cobro->nombre }}</td>
                  <td class="text-right">{{ number_format($cobro->monto, 2) }}</td>
                  <td>{{ $cobro->documento }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <div class="card-body card-padding">
          <div class="row">
            <div class="col-sm-3">
              <a href="{{ url('ingresos') }}" class="btn btn-block main-color waves-effect"><i class="zmdi zmdi-long-arrow-left"></i> Volver</a>
            </div>
            <div class="col-sm-3 col-sm-offset-6">
              <a href="{{ url("retiro/resumen/$id_retiro/reporte") }}" class="btn btn-block main-color waves-effect" target="_blank">PDF</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
