@extends('layouts.dashboard')

@section('title')
  Definir Descuentos
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
    <div class="col-sm-10">
      <div class="card hoverable">
        <div class="card-header main-color ch-alt">
          <h2>Definir Descuentos</h2>
        </div>
        <div class="card-body card-padding">
          <form action="{{ url('/admin/configuracion/guardar') }}" class="form-horizontal" method="POST">
            <input type="hidden" value="{{ csrf_token() }}" name="_token">
            <div class="form-group">
              <label for="dia_limite_descuento" class="control-label col-sm-3">Día límite de descuento</label>
              <div class="col-sm-9">
                <div class="fg-line">
                  <input type="text" id="dia_limite_descuento" name="dia_limite_descuento" class="form-control" placeholder="Ejemplo: 11" value="{{ $dia_limite_descuento }}">
                </div>
                <small class="help-block">Para las pensiones del instituto, ingrese el día límite (del siguiente mes) de aplicación del descuento.</small>
              </div>
            </div>
            <div class="form-group">
              <label for="porcentaje_descuento" class="control-label col-sm-3">Porcentaje de descuento</label>
              <div class="col-sm-9">
                <div class="fg-line">
                  <input type="text" id="porcentaje_descuento" name="porcentaje_descuento" class="form-control" placeholder="Ejemplo: 11" value="{{ $porcentaje_descuento }}">
                </div>
                <small class="help-block">Para las pensiones del instituto, ingrese el porcentaje de descuento.</small>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-3 col-sm-offset-9">
                <button type="submit" class="btn btn-block waves-effect m-t-15 accent-color">Guardar</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script src="{{ asset('js/angular.min.js') }}"></script>
  <script src="{{ asset('js/apps/matricula.crear.js') }}"></script>
@endsection
