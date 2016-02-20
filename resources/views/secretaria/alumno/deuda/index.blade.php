@extends('layouts.dashboard')

@section('title')
  Deudas de Alumno
@endsection

@section('content')
  <h1>DEUDAS DE ALUMNO</h1>

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
            <div class="form-group">
              <label for="dni" class="col-sm-3 control-label">DNI</label>
              <div class="col-sm-9">
                  <div class="fg-line">
                      <input type="text" class="form-control input-sm" id="dni" name="dni" placeholder="DNI">
                  </div>
              </div>
            </div>
            <div class="form-group">
              <div class="pull-right">
                <button class="btn btn-warning waves-effect">Buscar</button>
              </div>
            </div>
          {!!Form::close()!!}
        </div>
      </div>
      <div class="card">
        <div class="card-body card-padding">
          <div class="table-responsive">
              <table class="table table-bordered">
                  <thead>
                      <tr>
                          <th class="danger c-white">Deuda</th>
                          <th class="danger c-white">Monto (S/)</th>
                          <th class="danger c-white">Descuento</th>
                          <th class="danger c-white">¿Anular?</th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr>
                          <td>Matrícula 2016</td>
                          <td>300.00</td>
                          <td>
                              <div class="fg-line">
                                  <input type="text" class="form-control input-sm" placeholder="Descuento">
                              </div>
                          </td>
                          <td>
                              <div class="toggle-switch">
                                  <input id="ts1" type="checkbox" hidden="hidden">
                                  <label for="ts1" class="ts-helper"></label>
                              </div>
                          </td>
                      </tr>
                  </tbody>
              </table>
          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-body card-padding">
          {!!Form::open(['class' => 'form-horizontal'])!!}
            <div class="form-group">
              <label for="" class="control-label col-sm-3">FUT:</label>
              <div class="col-sm-9">
                <div class="fg-line"><input type="text" class="form-control"></div>
              </div>
            </div>
            <div class="form-group">
              <label for="" class="control-label col-sm-3">Código de autorización:</label>
              <div class="col-sm-9">
                <div class="fg-line"><input type="text" class="form-control"></div>
              </div>
            </div>
            <div class="form-group">
              <div class="pull-right">
                <button class="btn btn-warning waves-effect">Guardar</button>
              </div>
            </div>
          {!!Form::close()!!}
        </div>
      </div>
    </div>
  </div>
@endsection