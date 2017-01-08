@extends('layouts.dashboard')

@section('title')
  Resumen de Creación de Matrículas Temporales
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
    <div class="col-md-10">
      <div class="card hoverable">
        <div class="card-header main-color ch-alt">
          <h2>Resumen de Creación de Matrículas Temporales</h2>
        </div>
        <div class="card-body card-padding">
          <div class="alert alert-success" role="alert">
            Conceptos creados correctamente. Como siguiente paso se debe de programar las fechas de estos conceptos para que estén disponibles.
          </div>
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th class="accent-color c-white">Nivel / Carrera</th>
                  <th class="accent-color c-white">Concepto Matrícula</th>
                  <th class="accent-color c-white">Monto Matrícula</th>
                  <th class="accent-color c-white">Concepto Pensión</th>
                  <th class="accent-color c-white">Monto Pensión</th>
                </tr>
              </thead>
              <tbody>
                @foreach($categorias as $categoria)
                  <tr>
                    <td>{{ $categoria->nombre_division }}</td>
                    <td>{{ $categoria->concepto_matricula }}</td>
                    <td>{{ $categoria->monto_matricula }}</td>
                    <td>{{ $categoria->concepto_pension }}</td>
                    <td>{{ $categoria->monto_pension }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
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