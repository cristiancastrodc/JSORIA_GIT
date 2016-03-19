@extends('layouts.dashboard')

@section('title')
  Otros Conceptos
@endsection

@section('content')
  <h1>OTROS CONCEPTOS</h1>

  @if(Session::has('message'))
    <div class="alert alert-success alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      {{Session::get('message')}}
    </div>
  @endif

  @include('messages.errors')

  <div class="row">
    <div class="col-md-10">
      <div class="card">
        <div class="card-body card-padding">
          {!!Form::open(['class' => 'form-horizontal'])!!}
          <input type="hidden" id="_token" value="{{ csrf_token() }}">
          <div class="table-responsive">
            <table id="otros-conceptos" class="table table-striped">
              <thead>
                  <tr>
                      <th class="hidden">Id</th>
                      <th class="warning c-white">Nombre</th>
                      <th class="warning c-white">Monto</th>
                      <th class="warning c-white">¿Seleccionar?</th>
                  </tr>
              </thead>
              <tbody>
                @foreach($categorias as $categoria)
                  <tr>
                    <td class="hidden id">{{ $categoria->id }}</td>
                    <td class="nombre">{{ $categoria->nombre }}</td>
                    <td class="monto">{{ $categoria->monto }}</td>
                    <td class="hidden destino">{{ $categoria->destino }}</td>
                    <td>
                      <label class='checkbox checkbox-inline'><input type='checkbox' class='selected'><i class='input-helper'></i> Seleccionar</label>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <div class="form-group">
              <label for="DNI" class="col-sm-3 control-label">DNI</label>
              <div class="col-sm-9">
                  <div class="fg-line">
                      <input type="text" class="form-control input-sm" id="dni_cliente" name="DNI" placeholder="DNI">
                  </div>
              </div>
          </div>
          <div class="form-group">
              <label for="cliente_extr" class="col-sm-3 control-label">Nombre:</label>
              <div class="col-sm-9">
                  <div class="fg-line">
                      <input type="text" class="form-control input-sm" id="nombre_cliente" name="cliente_extr" placeholder="Nombre">
                  </div>
              </div>
          </div>
          <div class="form-group">
              <label for="ruc_cliente" class="control-label col-sm-3">RUC:</label>
              <div class="col-sm-9">
                  <div class="fg-line"><input type="text" class="form-control" id="ruc_cliente" placeholder="Solo ingresar en caso de factura"></div>
              </div>
          </div>
          <div class="form-group">
              <label for="razon_social" class="control-label col-sm-3">Razón Social:</label>
              <div class="col-sm-9">
                  <div class="fg-line"><input type="text" class="form-control" id="razon_social" placeholder="Solo ingresar en caso de factura"></div>
              </div>
          </div>
          <div class="form-group">
              <label for="direccion" class="control-label col-sm-3">Dirección:</label>
              <div class="col-sm-9">
                  <div class="fg-line"><input type="text" class="form-control" id="direccion" placeholder="Solo ingresar en caso de factura"></div>
              </div>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-sm-3 col-sm-offset-9">
                <button class="btn bgm-blue-soria btn-block m-t-10" id="btn-cobrar-multiple"> Cobrar</button>
              </div>
            </div>
          </div>
          {!!Form::close()!!}
        </div>
      </div>
    </div>
  </div>
@endsection

@section('modals')
  @include('cajera.cobros.modal')
@endsection

@section('scripts')
  <script src="{{ asset('js/cajera.js') }}"></script>
@endsection