@extends('layouts.dashboard')

@section('title')
  Resumen de Creación de Actividad
@endsection

@section('content')

  @if(Session::has('message'))
  <div class="row">
    <div class="col-sm-10">
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
          <h2>Resumen de Creación de Actividad</h2>
        </div>
        <div class="card-body card-padding">
          <div class="alert alert-success" role="alert">
            Actividad creada correctamente.
          </div>
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th class="accent-color c-white">Nivel / Carrera</th>
                  <th class="accent-color c-white">Descripción</th>
                  <th class="accent-color c-white">Monto</th>
                  <th class="accent-color c-white">Observación</th>
                </tr>
              </thead>
              <tbody>
                @foreach($actividades as $actividad)
                  <tr>
                    <td>{{ $actividad->nombre_division }}</td>
                    <td>{{ $actividad->nombre }}</td>
                    <td class="text-right">{{ $actividad->monto }}</td>
                    <td> Se agregó {{ $actividad->nro_alumnos }} pagos de alumnos.</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <div class="row m-t-15">
            <div class="col-sm-3">
              <a href="{{ url('/admin/actividades') }}" class="btn btn-block main-color waves-effect"><i class="zmdi zmdi-long-arrow-left"></i> Volver</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection