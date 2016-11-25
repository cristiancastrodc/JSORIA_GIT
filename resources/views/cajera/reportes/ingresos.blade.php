@extends('layouts.dashboard')

@section('title')
  Reporte de Cobros
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
    <div class="col-md-8">
      <div class="card hoverable">
        <div class="card-header main-color ch-alt">
          <h2>REPORTE DE COBROS</h2>
        </div>
        <div class="card-body card-padding">
          <form action="{{ url('/cajera/reporte/generar') }}" method="POST" class="form-horizontal">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
              <label for="fecha" class="col-sm-3 control-label">Fecha:</label>
                <div class="col-sm-9">
                    <div class="fg-line">
                        <div class="dtp-container fg-line">
                            <input type='text' class="form-control date-picker" placeholder="Fecha" name="fecha" id="fecha" autocomplete="off">
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
              <div class="pull-right">
                <button type="submit" class="btn btn-warning waves-effect" id="btn-reporte-EgresosRubro" formtarget="_blank">Generar</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script src="{{ asset('js/reportes.js') }}"></script>
@endsection