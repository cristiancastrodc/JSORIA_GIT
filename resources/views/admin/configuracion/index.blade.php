@extends('layouts.dashboard')

@section('title')
  Definir Descuentos
@endsection

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
    <div class="col-sm-12">
      <div class="card hoverable">
        <div class="card-header main-color ch-alt">
          <h2>Definir Descuentos</h2>
        </div>
        <div class="card-body card-padding">
          <form action="{{ url('/admin/configuracion/guardar') }}" class="form-horizontal" method="POST">
            <input type="hidden" value="{{ csrf_token() }}" name="_token">
            <h2 class="h4">Instituto Urusayhua</h2>
            <div class="form-group">
              <label for="dia_limite_instituto" class="control-label col-sm-3">Día límite de descuento</label>
              <div class="col-sm-9">
                <div class="fg-line">
                  <input type="text" id="dia_limite_instituto" name="dia_limite_instituto" class="form-control" placeholder="Ejemplo: 11" value="{{ $dia_limite_instituto }}">
                </div>
                <small class="help-block">Para las pensiones del Instituto, ingrese el día límite (del siguiente mes) de aplicación del descuento.</small>
              </div>
            </div>
            <div class="form-group">
              <label for="porcentaje_instituto" class="control-label col-sm-3">Porcentaje de descuento</label>
              <div class="col-sm-9">
                <div class="fg-line">
                  <input type="text" id="porcentaje_instituto" name="porcentaje_instituto" class="form-control" placeholder="Ejemplo: 11" value="{{ $porcentaje_instituto }}">
                </div>
                <small class="help-block">Para las pensiones del Instituto, ingrese el porcentaje de descuento.</small>
              </div>
            </div>
            <h2 class="h4">Universidad Líder Peruana</h2>
            <div class="form-group">
              <label for="dia_limite_ulp" class="control-label col-sm-3">Día límite de descuento</label>
              <div class="col-sm-9">
                <div class="fg-line">
                  <input type="text" id="dia_limite_ulp" name="dia_limite_ulp" class="form-control" placeholder="Ejemplo: 11" value="{{ $dia_limite_ulp }}">
                </div>
                <small class="help-block">Para las pensiones de la Universidad, ingrese el día límite (del siguiente mes) de aplicación del descuento.</small>
              </div>
            </div>
            <div class="form-group">
              <label for="porcentaje_ulp" class="control-label col-sm-3">Porcentaje de descuento</label>
              <div class="col-sm-9">
                <div class="fg-line">
                  <input type="text" id="porcentaje_ulp" name="porcentaje_ulp" class="form-control" placeholder="Ejemplo: 11" value="{{ $porcentaje_ulp }}">
                </div>
                <small class="help-block">Para las pensiones de la Universidad, ingrese el porcentaje de descuento.</small>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-3 col-sm-offset-9">
                <button type="submit" class="btn btn-block waves-effect accent-color">Guardar</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
