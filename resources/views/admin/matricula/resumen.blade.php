@extends('layouts.dashboard')

@section('title', 'Resumen de Creación de Matrícula')

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
          <h2>Resumen de Creación de Matrícula</h2>
        </div>
        <div class="card-body card-padding">
          <div class="alert alert-success" role="alert">
            Matrícula y pensiones creadas correctamente.
          </div>
        </div>
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th class="accent-color c-white">Nivel / Carrera</th>
                <th class="accent-color c-white">Descripción</th>
                <th class="accent-color c-white">Monto</th>
                <th class="accent-color c-white">Fecha Inicio</th>
                <th class="accent-color c-white">Fecha Fin</th>
              </tr>
            </thead>
            <tbody>
              @foreach($categorias as $categoria)
                <tr>
                  <td>{{ $categoria->nombre_division }}</td>
                  <td>{{ $categoria->nombre }}</td>
                  <td class="text-right">{{ $categoria->monto }}</td>
                  <td class="text-right">{{ $categoria->fecha_inicio }}</td>
                  <td class="text-right">{{ $categoria->fecha_fin }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <div class="card-body card-padding">
          <div class="row m-t-15">
            <div class="col-sm-3">
              <a href="{{ url('admin/matricula/crear') }}" class="btn btn-block main-color waves-effect"><i class="zmdi zmdi-long-arrow-left"></i> Volver</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection