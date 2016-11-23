@extends('layouts.dashboard')

@section('title')
  Reporte de Balance
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
          <h2>Reporte De Balance</h2>
        </div>
        <div class="card-body card-padding">
          {!!Form::open(array('class' => 'form-horizontal', 'id' => 'form-reporte-admin-balance', 'route' => 'admin.reporte.balance_ingresos_egresos.procesar', 'method' => 'POST'))!!}
            <div class="form-group">
              <label for="id_tesorera" class="col-sm-3 control-label">Seleccionar tesorera:</label>
              <div class="col-sm-9 text-uppercase">
                <select class="selectpicker" name="id_tesorera" id="id_tesorera" title='Seleccione'>
                  @foreach ($tesoreras as $tesorera)
                    <option value="{{ $tesorera->id }}">{{ $tesorera->nombres }} {{ $tesorera->apellidos }}</option>
                  @endforeach
                </select>
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
            <div class="form-group">
              <div class="col-sm-3 col-sm-offset-9">
                <button type="submit" class="btn btn-block waves-effect m-t-15 accent-color" formtarget="_blank">Generar</button>
              </div>
            </div>
          {!!Form::close()!!}
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script src="{{ asset('js/reportes.js') }}"></script>
@endsection
