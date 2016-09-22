@extends('layouts.dashboard')

@section('title')
  Autorización Descuento Mediante Resolución
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
          <h2>Autorizar Descuento</h2>
        </div>
        <div class="card-body card-padding">
          {!!Form::open(array('route' => 'admin.autorizacion.store', 'class' => 'form-horizontal', 'method' => 'POST'))!!}
            <div class="form-group">
              <label for="dni" class="col-sm-3 control-label">Alumno</label>
              <div class="col-sm-9">
                  <div class="fg-line">
                      <input type="text" class="form-control input-sm" id="nro_documento" name="nro_documento" placeholder="Documeto de alumno">
                  </div>
              </div>
            </div>
            <div class="form-group">
              <label for="fut" class="col-sm-3 control-label">Resolucion</label>
              <div class="col-sm-9">
                  <div class="fg-line">
                      <input type="text" class="form-control input-sm" id="rd" name="rd" placeholder="Numero de RD">
                  </div>
              </div>
            </div>
            <div class="form-group">
              <label for="fecha_fin" class="col-sm-3 control-label">Fecha Limite</label>
              <div class="col-sm-9">
                  <div class="fg-line">
                      <div class="dtp-container fg-line">
                          <input type='text' class="form-control date-picker" placeholder="Fecha" name="fecha_limite" id="fecha_limite" autocomplete="off">
                      </div>
                  </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-3 col-sm-offset-9">
                <button class="btn btn-block accent-color waves-effect m-t-10" id="btn-crear-matricula">Autorizar</button>
              </div> 
            </div>            
          {!!Form::close()!!}
        </div>
      </div>
    </div>
  </div>
@endsection