@extends('layouts.dashboard')

@section('title')
  Agregar Deuda
@endsection

@section('content')
  <h1>AGREGAR DEUDA</h1>

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
                          <th class="danger c-white">Concepto</th>
                          <th class="danger c-white">Monto Unit (S/)</th>
                          <th class="danger c-white">Cantidad</th>
                          <th class="danger c-white">Total (S/)</th>
                      </tr>
                  </thead>
                  <tbody>
                    <tr>
                        <td>Certificado</td>
                        <td>20.00</td>
                        <td>
                          <div class="fg-line">
                              <input type="text" class="form-control input-sm" placeholder="Cantidad">
                          </div>
                        </td>
                    </tr>
                  </tbody>
              </table>
          </div>
          <div class="form-group">
            <div class="pull-right">
              <button class="btn btn-warning waves-effect">Guardar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection