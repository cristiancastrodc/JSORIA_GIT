@extends('layouts.dashboard')

@section('title')
  Configuración de Impresora
@endsection

@section('content')
  <h1>CONFIGURACIÓN DE IMPRESORA</h1>

  @if(Session::has('message'))
    <div class="alert alert-success alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      {{Session::get('message')}}
    </div>
  @endif

  @include('messages.errors')

  <div class="row">
    <div class="col-md-8">
      <div class="card">
        <div class="card-body card-padding">
          {!!Form::open(['class' => 'form-horizontal'])!!}
          <input type="hidden" id="_token" value="{{ csrf_token() }}">
          <div class="form-group">
              <label for="tipo_impresora" class="col-sm-3 control-label">Tipo de Impresora:</label>
              <div class="col-sm-9">
                <select class="selectpicker" name="tipo_impresora" id="tipo_impresora" title='Seleccione'>
                  <option value="matricial">Matricial</option>
                  <option value="ticketera">Ticketera</option>
                </select>
              </div>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-sm-6 col-sm-offset-6">
                <button class="btn bgm-blue-soria btn-block m-t-10" id="btn-guardar-conf-impresora"> Guardar Configuración</button>
              </div>
            </div>
          </div>
          {!!Form::close()!!}
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script src="{{ asset('js/cajera.js') }}"></script>
@endsection