@extends('layouts.dashboard')

@section('title')
  Egresos
@endsection

@section('content')

  @if(Session::has('message'))
  <div class="row">
    <div class="col-sm-12">
      <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
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
          <h2>Buscar Egresos</h2>
        </div>
        <div class="card-body card-padding">
          <form class="form-horizontal">
            <input type="hidden" id="_token" value="{{ csrf_token() }}">
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
                <button class="btn accent-color waves_effect btn-block" id="btn-buscar-egresos"><i class="zmdi zmdi-search"></i> Buscar</button>
              </div>
            </div>
          </form>
        </div>
        <form id="form-lista-egresos" class="hidden">
          <div class="table-responsive">
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
          </div>
        </form>
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