@extends('layouts.dashboard')

@section('title', 'Otros Conceptos')

@section('content')

  @if(Session::has('message'))
    <div class="row">
      <div class="col-sm-12">
        <div class="alert alert-success alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          {{ Session::get('message') }}
        </div>
      </div>
    </div>
  @endif

  @include('messages.errors')

  <div ng-app="registrarCobros" ng-controller="ingresosMultiplesController">
    <div class="row">
      <div class="col-md-12">
        <div class="card hoverable">
          <div class="card-header main-color ch-alt">
            <h2>Conceptos</h2>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th class="accent-color c-white">Nombre</th>
                    <th class="accent-color c-white">Institución</th>
                    <th class="accent-color c-white">Monto</th>
                    <th class="accent-color c-white">¿Seleccionar?</th>
                  </tr>
                  <tr class="search-row">
                    <th><input type="text" class="form-control table-input" placeholder="Buscar..." ng-model="busqueda.nombre"></th>
                    <th><input type="text" class="form-control table-input" placeholder="Buscar..." ng-model="busqueda.institucion"></th>
                    <th></th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr ng-repeat="categoria_aux in categorias | filter : { nombre : busqueda.nombre } : filtroNombre | filter : { institucion : busqueda.institucion } : filtroInstitucion">
                    <td>{@ categoria_aux.nombre @}</td>
                    <td>{@ categoria_aux.institucion @}</td>
                    <td class="text-right">{@ categoria_aux.monto @}</td>
                    <td>
                      <div class="radio table-radio">
                        <label>
                          <input type="radio" class="rb" name="categoria_seleccionada" ng-model="$parent.categoria" ng-value="categoria_aux">
                          <i class="input-helper"></i>
                          Seleccionar
                        </label>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div ng-show="categoria!=null">
            <div class="card-body card-padding">
              <form class="form-horizontal">
                <input type="hidden" value="{{ csrf_token() }}" id="_token">
                <div class="form-group">
                  <label for="dni" class="col-sm-4 control-label">DNI:</label>
                  <div class="col-sm-8">
                    <div class="fg-line">
                      <input type="text" class="form-control" id="dni" name="dni" placeholder="DNI" ng-model="cliente.dni">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="nombre_cliente" class="col-sm-4 control-label">Nombre:</label>
                  <div class="col-sm-8">
                    <div class="fg-line">
                      <input type="text" class="form-control" id="nombre_cliente" name="nombre_cliente" placeholder="Nombre" ng-model="cliente.nombre">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="tipo_comprobante" class="control-label col-sm-4">Tipo de Comprobante:</label>
                  <div class="col-sm-8">
                    <div class="fg-line">
                      <div class="select">
                        <select name="tipo_comprobante" id="tipo_comprobante" class="form-control" ng-model="comprobante.tipo" ng-change="cargarSeries()">
                          <option value="" disabled="">-- SELECCIONE TIPO DE COMPROBANTE --</option>
                          <option value="comprobante">Comprobante</option>
                          <option value="boleta" ng-disabled="categoria.destino==1">Boleta</option>
                          <option value="factura" ng-disabled="categoria.destino==1">Factura</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="serie_comprobante" class="control-label col-sm-4">Serie de Comprobante:</label>
                  <div class="col-sm-8">
                    <div class="fg-line">
                      <div class="select">
                        <select name="serie_comprobante" id="serie_comprobante" class="form-control" ng-options="comprobante_aux.serie as comprobante_aux.serie for comprobante_aux in comprobantes" ng-model="comprobante.serie" ng-change="cargarNumero()">
                          <option value="" disabled="">-- SELECCIONE SERIE --</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="numero_comprobante" class="control-label col-sm-4">Número de Comprobante:</label>
                  <div class="col-sm-8">
                    <div class="fg-line">
                      <input type="text" name="numero_comprobante" id="numero_comprobante" class="form-control" ng-model="comprobante.numero" placeholder="Número de Comprobante">
                    </div>
                  </div>
                </div>
                <hr>
                <div ng-show="comprobante.tipo=='factura'">
                  <div class="form-group">
                    <label for="ruc_cliente" class="control-label col-sm-3">RUC:</label>
                    <div class="col-sm-8">
                      <div class="fg-line">
                        <input type="text" class="form-control" id="ruc_cliente" placeholder="RUC" ng-model="cliente.ruc">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="razon_social" class="control-label col-sm-3">Razón Social:</label>
                    <div class="col-sm-8">
                      <div class="fg-line">
                        <input type="text" class="form-control" id="razon_social" placeholder="Razón Social" ng-model="cliente.razon_social">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="direccion" class="control-label col-sm-3">Dirección:</label>
                    <div class="col-sm-8">
                      <div class="fg-line">
                        <input type="text" class="form-control" id="direccion" placeholder="Dirección" ng-model="cliente.direccion">
                      </div>
                    </div>
                  </div>
                  <hr>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-4">Total:</label>
                  <div class="col-sm-8">
                    <div class="fg-line">
                      <input type="text" class="form-control text-right f-20" ng-model="categoria.monto" ng-disabled="true">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-4">Pagó con:</label>
                  <div class="col-sm-8">
                    <div class="fg-line">
                      <input type="number" class="form-control text-right f-20" ng-model="efectivo" ng-change="calcularVuelto()">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-4">Vuelto:</label>
                  <div class="col-sm-8">
                    <div class="fg-line">
                      <input type="text" class="form-control text-right f-20" ng-model="vuelto" ng-disabled="true">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-3 col-sm-offset-6">
                    <button class="btn btn-block btn-link waves-effect" type="button" ng-click="inicializar()"><i class="zmdi zmdi-close-circle-o"></i> Cancelar</button>
                  </div>
                  <div class="col-sm-3">
                    <button class="btn main-color btn-block" type="button" ng-disabled="procesando || !esValidoFormCreacion()" ng-click="grabarIngreso()">
                      <span ng-hide="procesando"><i class="zmdi zmdi-assignment-check"></i> Guardar</span>
                      <span ng-show="procesando">
                        <span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> Procesando...
                      </span>
                    </button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script src="{{ asset('js/angular.min.js') }}"></script>
  <script src="{{ asset('js/apps/cobros.registrar.js') }}"></script>
@endsection
