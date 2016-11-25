@extends('layouts.dashboard')

@section('title')
  Retirar Ingresos Adicionales
@endsection

@section('content')

  @if(Session::has('message'))
    <div class="row">
      <div class="col-sm-10">
        <div class="alert alert-success alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          {{Session::get('message')}}
        </div>
      </div>
    </div>
  @endif

  @include('messages.errors')

  <div class="row">
    <div class="col-md-10">
      <div class="card hoverable">
        <div class="card-header main-color ch-alt">
          <h2>Registrar Ingresos Adicionales</h2>
        </div>
        <div class="card-body card-padding">
          <form action="{{ url('tesorera/registrar/ingresos/guardar') }}" class="form-horizontal" method="POST">
          <input type="hidden" value="{{ csrf_token() }}" name="_token">
            <div class="form-group">
              <label for="id_institucion" class="control-label col-sm-3">Institución</label>
              <div class="col-sm-9">
                <select name="id_institucion" id="id_institucion" class="selectpicker" title="Seleccione Institución">
                  <option value="1">I.E. J. Soria</option>
                  <option value="2">CEBA Konrad Adenauer</option>
                  <option value="3">I.S.T. Urusayhua</option>
                  <option value="4">Universidad Privada Líder Peruana</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="monto" class="control-label col-sm-3">Monto</label>
              <div class="col-sm-9">
                <div class="fg-line">
                  <input type="text" name="monto" id="monto" class="form-control">
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-3 col-sm-offset-9">
                <button type="submit" class="btn btn-block main-color waves-effect">Guardar</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
