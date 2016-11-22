@extends('layouts.dashboard')

@section('title')
  Resultados de la búsqueda
@endsection

@section('content')

  <div class="row">
    <div class="col-sm-12">
      <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        {{ $mensaje }}
      </div>
    </div>
  </div>

  @include('messages.errors')

  <div class="row">
    <div class="col-md-12">
      <div class="card hoverable">
        <div class="card-header main-color ch-alt">
          <h2>Resultados de la búsqueda</h2>
        </div>
        <div class="card-body card-padding">
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Nombres</th>
                  <th>Apellidos</th>
                  <th>Número Documento</th>
                  <th>Institución</th>
                </tr>
              </thead>
              <tbody>
                @foreach($resultado as $alumno)
                <tr>
                  <td>{{ $alumno->nombres }}</td>
                  <td>{{ $alumno->apellidos }}</td>
                  <td>{{ $alumno->nro_documento }}</td>
                  <td>{{ $alumno->institucion }} - {{ $alumno->nivel }} - {{ $alumno->grado }}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
