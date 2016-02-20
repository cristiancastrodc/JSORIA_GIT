@extends('layouts.dashboard')

@section('title')
  Egresos
@endsection

@section('content')
  <h1>EGRESOS</h1>

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
                <label for="fecha" class="col-sm-3 control-label">Fecha</label>
                <div class="col-sm-6">
                    <div class="fg-line">
                        <div class="dtp-container fg-line">
                            <input type='text' class="form-control date-picker" placeholder="Elija la fecha" name="fecha" id="fecha">
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                  <button class="btn btn-primary waves_effect" id="buscar_egresos">Buscar</button>
                </div>
            </div>
          {!!Form::close()!!}
          <h4>Lista de Egresos</h4>
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th class="warning c-white">Institución</th>
                  <th class="warning c-white">Tipo de Comprobante</th>
                  <th class="warning c-white">Número</th>
                  <th class="warning c-white">Acciones</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>I.E. J. Soria</td>
                  <td>Boleta</td>
                  <td>5642</td>
                  <td>
                    <button class="btn btn-primary btn-icon waves-effect"><i class="zmdi zmdi-edit"></i></button>
                    <button class="btn btn-danger btn-icon waves-effect"><i class="zmdi zmdi-delete"></i></button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection