@extends('layouts.dashboard')

@section('title')
  Retirar Ingresos
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
          <h2>Retiro</h2>
        </div>
        <div class="card-body card-padding">
          {!! Form::open(['class' => 'form-horizontal', 'id' => 'form-ingresos-cajera']) !!}
            <div class="form-group">
              <label for="id_institucion" class="col-sm-3 control-label">Seleccionar Cajera:</label>
              <div class="col-sm-9">
                <select class="selectpicker" name="id_cajera" id="id_cajera" title='Seleccione'>
                  @foreach ($cajeras as $cajera)
                    <option value="{{ $cajera->id }}">{{ $cajera->nombres }} {{ $cajera->apellidos }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-3 col-sm-offset-9">
                <button class="btn btn-block accent-color waves-effect m-t-10" id="btn-ingresos-cajera">Buscar</button>
              </div>
            </div>
          {!! Form::close() !!}
        </div>
      </div>
      <div class="card js-toggle hoverable" id="card-ingresos-admin">
        <div class="card-body card-padding">
          {!! Form::open(['class' => 'form-horizontal']) !!}
            <input type="hidden" value="{{ csrf_token() }}" id="_token">
            <input type="hidden" id="id_cajera_retirar">
            <div class="table-responsive">
              <table class="table table-bordered" id="tabla-ingresos-cajera">
                <thead>
                  <tr>
                    <th class="hidden">Id</th>
                    <th class="accent-color c-white">Fecha de Ingreso</th>
                    <th class="accent-color c-white">Concepto</th>
                    <th class="accent-color c-white">Estado</th>
                    <th class="accent-color c-white">Monto (S/)</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot class="text-right bgm-orange c-white">
                  <tr>
                    <td colspan="3">TOTAL NO RETIRADO (S/)</td>
                    <td id="cobros-no-retirados"></td>
                  </tr>
                  <tr>
                    <td colspan="3">TOTAL POR RETIRAR (S/)</td>
                    <td id="cobros-por-retirar"></td>
                  </tr>
                </tfoot>
              </table>
            </div>
            <div class="form-group">
              <div class="col-sm-3 col-sm-offset-9">
                <button class="btn btn-block accent-color waves-effect m-t-10" id="btn-retirar-ingresos">Retirar</button>
              </div>
            </div>
          {!! Form::close() !!}
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script src="{{ asset('js/tesorera.js') }}"></script>
@endsection