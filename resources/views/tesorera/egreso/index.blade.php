@extends('layouts.dashboard')

@section('title')
  Egresos
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
          <h2>Buscar Egresos</h2>
        </div>
        <div class="card-body card-padding">
          {!!Form::open(['class' => 'form-horizontal'])!!}
            <div class="form-group">
                <label for="fecha" class="col-sm-3 control-label">Fecha</label>
                <div class="col-sm-6">
                    <div class="fg-line">
                        <div class="dtp-container fg-line">
                            <input type='text' class="form-control" placeholder="Elija la fecha" name="fecha_egresos" id="fecha_egresos">
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                  <button class="btn accent-color waves_effect btn-block" id="btn-buscar-egresos">Buscar</button>
                </div>
            </div>
          {!!Form::close()!!}
        </div>
      </div>
      <div class="card js-toggle hoverable" id="card-lista-egresos">
        <div class="card-header main-color ch-alt">
          <h2>Egresos</h2>
        </div>                    
          <div class="table-responsive">
            {!! Form::open() !!}
            <input type="hidden" id="_token" value="{{ csrf_token() }}">
            <table class="table table-bordered" id="tabla-listar-egresos">
              <thead>
                <tr>
                  <th class="accent-color c-white">Institución</th>
                  <th class="accent-color c-white">Tipo de Comprobante</th>
                  <th class="accent-color c-white">Número de Comprobante</th>
                  <th class="accent-color c-white">Acciones</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
            {!! Form::close() !!}
          </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script src="{{ asset('js/tesorera.js') }}"></script>
  <script>
    $('#fecha_egresos').datetimepicker({
          format: 'YYYY/MM/DD',
          locale : 'es',
          minDate : moment().subtract(30, 'days')
    });
  </script>
@endsection