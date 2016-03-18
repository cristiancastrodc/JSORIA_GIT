@extends('layouts.dashboard')

@section('title')
  Egresos
@endsection

@section('content')
  <h1>BUSCAR EGRESOS</h1>

  @if(Session::has('message'))
    <div class="alert alert-success alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      {{Session::get('message')}}
    </div>
  @endif

  @include('messages.errors')

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body card-padding">
          {!!Form::open(['class' => 'form-horizontal'])!!}
            <div class="form-group">
                <label for="fecha" class="col-sm-3 control-label">Fecha</label>
                <div class="col-sm-6">
                    <div class="fg-line">
                        <div class="dtp-container fg-line">
                            <input type='text' class="form-control date-picker" placeholder="Elija la fecha" name="fecha_egresos" id="fecha_egresos">
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                  <button class="btn bgm-blue-soria waves_effect btn-block" id="btn-buscar-egresos">Buscar</button>
                </div>
            </div>
          {!!Form::close()!!}
        </div>
      </div>
      <div class="card js-toggle" id="card-lista-egresos">
        <div class="card-body card-padding">
          <h4>Lista de Egresos</h4>
          <div class="table-responsive">
            <table class="table table-bordered" id="tabla-listar-egresos">
              <thead>
                <tr>
                  <th class="warning c-white">Institución</th>
                  <th class="warning c-white">Tipo de Comprobante</th>
                  <th class="warning c-white">Número de Comprobante</th>
                  <th class="warning c-white">Acciones</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script src="{{ asset('js/tesorera.js') }}"></script>
@endsection