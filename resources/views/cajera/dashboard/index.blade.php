@extends('layouts.dashboard')

@section('title')
  Escritorio
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
        <div class="card-body card-padding">
          {!!Form::open(['class' => 'form-horizontal', 'id' => 'form-buscar-deudas'])!!}
            <input type="hidden" id="tipo-impresora" value="{{ $tipo_impresora }}">
            <div class="form-group">
              <label for="codigo" class="col-sm-3 control-label">Ingrese código</label>
              <div class="col-sm-6">
                  <div class="fg-line">
                      <input type="text" class="form-control input-sm" id="codigo" name="codigo" placeholder="DNI de alumno o Código de pago">
                  </div>
              </div>
              <div class="col-sm-3">
                <button class="btn accent-color btn-block waves-effect" id="btn-buscar-deudas">Buscar</button>
              </div>
            </div>
          {!!Form::close()!!}
        </div>
      </div>
      <div class="card js-toggle hoverable" id="card-deudas-alumno">
        <div class="card-header">
          <h3><span id="nombre-alumno" class="text-uppercase"></span></h3>
          <h4><span id="nombre-institucion"></span></h4>
          <input type="hidden" id="id_institucion">
          <input type="hidden" id="nro_documento">
          <input type="hidden" id="id_pagos">
          <input type="hidden" id="id_compras">
          <input type="hidden" id="_token" value="{{ csrf_token() }}">
        </div>
        <div class="card-body card-padding">
          <h4>Pagos Pendientes</h4>
          <div class="table-responsive">
            <table id="tabla-pagos-pendientes" class="table table-striped">
              <thead>
                  <tr>
                      <th class="hidden">Id</th>
                      <th class="accent-color c-white">Concepto</th>
                      <th class="accent-color c-white">Monto (S/)</th>
                      <th class="accent-color c-white">Acciones</th>
                  </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
          <h4 id="btn-toggle-compras">Compras <i class="zmdi zmdi-menu"></i></h4>
          <div id="compras-toggle" class="form-group" style="display:none">
            <div class="table-responsive">
              <table id="tabla-categorias-compras" class="table table-striped">
                <thead>
                    <tr>
                        <th class="hidden">Id</th>
                        <th class="accent-color c-white">Cantidad</th>
                        <th class="accent-color c-white">Concepto</th>
                        <th class="accent-color c-white">Monto Unit. (S/)</th>
                        <th class="accent-color c-white">Importe</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-3 col-sm-offset-9">
                <button class="btn btn-block accent-color waves-effect m-t-10" id="btn-finalizar-pago">Finalizar</button>
              </div>
          </div>
        </div>
      </div>
      <div class="card js-toggle hoverable" id="card-deuda-extraordinaria">
        <div class="card-header main-color ch-alt">
          <h2>Cobrar</h2>
        </div>
        <div class="card-body card-padding">
          <form class="form-horizontal" role="form">
            <input type="hidden" id="_token-extr" value="{{ csrf_token() }}">
            <input type="hidden" id="id_deuda_extr">
            <div class="form-group">
              <label class="control-label col-sm-3">Cliente</label>
              <div class="col-sm-9">
                <p class="form-control-static"><span id="cliente_extr" class="text-uppercase"></span></p>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-3">Concepto</label>
              <div class="col-sm-9">
                <p class="form-control-static"><span id="descripcion_extr"></span></p>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-3">Monto</label>
              <div class="col-sm-9">
                <p class="form-control-static">S/ <span id="monto_extr"></span></p>
              </div>
            </div>
            @if ($tipo_impresora == 'matricial')
              <div class="form-group">
                  <label for="ruc_cliente" class="control-label col-sm-3">RUC:</label>
                  <div class="col-sm-9">
                      <div class="fg-line"><input type="text" class="form-control" id="ruc_cliente_extr" placeholder="Solo ingresar en caso de factura"></div>
                  </div>
              </div>
              <div class="form-group">
                  <label for="razon_social" class="control-label col-sm-3">Razón Social:</label>
                  <div class="col-sm-9">
                      <div class="fg-line"><input type="text" class="form-control" id="razon_social_extr" placeholder="Solo ingresar en caso de factura"></div>
                  </div>
              </div>
              <div class="form-group">
                  <label for="direccion" class="control-label col-sm-3">Dirección:</label>
                  <div class="col-sm-9">
                      <div class="fg-line"><input type="text" class="form-control" id="direccion_extr" placeholder="Solo ingresar en caso de factura"></div>
                  </div>
              </div>
            @endif
            <div class="form-group">
              <div class="col-sm-12">
                <div class="pull-right">
                  <button type="button" class="btn btn-link waves-effect cobro_extr">Cancelar</button>
                  <button type="button" class="btn third-color waves-effect" id="btn-comprobante-extr">Comprobante</button>
                  @if ($tipo_impresora == 'matricial')
                    <button type="button" class="btn accent-color waves-effect" id="btn-boleta-extr">Boleta</button>
                    <button type="button" class="btn fourth-color waves-effect" id="btn-factura-extr">Factura</button>
                  @endif
                </div>
              </div>
            </div>
            <div id="datos-comprobante-extr" style="display: none;">
              <h4>Datos de comprobante</h4>
              <input type="hidden" id="tipo-comprobante-extr">
              <div class="form-group">
                <label class="control-label col-sm-3">Serie</label>
                <div class="col-sm-9">
                  <p class="form-control-static" id="serie-comprobante-extr"></p>
                </div>
              </div>
              <div class="form-group">
                <label for="numero-comprobante-extr" class="control-label col-sm-3">Número</label>
                <div class="col-sm-9">
                  <div class="fg-line">
                    <input type="text" class="form-control" id="numero-comprobante-extr" name="numero-comprobante-extr">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-3 col-sm-offset-9">
                  <button type="button" class="btn accent-color btn-block waves-effect" id="btn-guardar-cobro-extr">Guardar</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('modals')
  @include('cajera.dashboard.modal')
@endsection

@section('scripts')
  <script src="{{ asset('js/cajera.js') }}"></script>
@endsection