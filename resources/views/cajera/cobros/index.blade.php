@extends('layouts.dashboard')

@section('title')
  Otros Conceptos
@endsection

@section('styles')
  <style>
    #datos-factura {
      display: none;
    }
  </style>
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
          <h2>Cobros</h2>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-striped" id="tabla-cobros-multiples">
              <thead>
                  <tr>
                      <th class="hidden">Id</th>
                      <th class="accent-color c-white">Nombre</th>
                      <th class="accent-color c-white">Institución</th>
                      <th class="accent-color c-white">Monto</th>
                      <th class="accent-color c-white">¿Seleccionar?</th>
                  </tr>
              </thead>
              <tbody>
                @foreach($categorias as $categoria)
                  <tr>
                    <td class="hidden id">{{ $categoria->id }}</td>
                    <td class="nombre">{{ $categoria->categoria }}</td>
                    <td class="nombre">{{ $categoria->institucion }}</td>
                    <td class="hidden id_institucion">{{ $categoria->id_institucion }}</td>
                    <td class="monto text-right">{{ $categoria->monto }}</td>
                    <td class="hidden destino">{{ $categoria->destino }}</td>
                    <td>
                      <div class="radio table-radio">
                        <label>
                          <input type="radio" class="rb cobro-multiple" name="rb-cobro-multiple">
                          <i class="input-helper"></i>
                          Seleccionar
                        </label>
                      </div>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="card hoverable">
        <div class="card-body card-padding">
          {!!Form::open(['class' => 'form-horizontal'])!!}
          <input type="hidden" id="_token" value="{{ csrf_token() }}">
          <div class="form-group">
              <label for="dni_cliente" class="col-sm-3 control-label">DNI</label>
              <div class="col-sm-9">
                  <div class="fg-line">
                      <input type="text" class="form-control input-sm" id="dni_cliente" name="dni_cliente" placeholder="DNI">
                  </div>
              </div>
          </div>
          <div class="form-group">
              <label for="nombre_cliente" class="col-sm-3 control-label">Nombre:</label>
              <div class="col-sm-9">
                  <div class="fg-line">
                      <input type="text" class="form-control input-sm" id="nombre_cliente" name="nombre_cliente" placeholder="Nombre">
                  </div>
              </div>
          </div>
          <div class="form-group">
            <label for="tipo_comprobante" class="control-label col-sm-3">Tipo de Comprobante</label>
            <div class="col-sm-9">
              <div class="fg-line">
                <div class="select">
                  <select name="tipo_comprobante" id="tipo_comprobante" class="form-control">
                    <option value="">Seleccione Tipo de Comprobante</option>
                    <option value="comprobante">Comprobante</option>
                    <option value="boleta">Boleta</option>
                    <option value="factura">Factura</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="serie_comprobante" class="control-label col-sm-3">Serie de Comprobante</label>
            <div class="col-sm-9">
              <select name="serie_comprobante" id="serie_comprobante" class="form-control selectpicker" title="Seleccione">
                <option value="">Seleccione Serie</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="numero_comprobante" class="control-label col-sm-3">Número de Comprobante</label>
            <div class="col-sm-9">
              <div class="fg-line">
                <input type="text" name="numero_comprobante" id="numero_comprobante" class="form-control">
              </div>
            </div>
          </div>
          <hr>
          <div id="datos-factura">
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
          </div>
          <div class="form-group">
            <div class="row p-r-15">
              <div class="col-sm-3 col-sm-offset-9">
                <button class="btn third-color btn-block m-t-10" id="btn-cobro-multiple"> Finalizar Cobro</button>
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
  <script src="{{ asset('js/cajera.otros_cobros.js') }}"></script>
@endsection