@extends('layouts.dashboard')

@section('title')
  Cobros
@endsection

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

  <div ng-app="registrarCobros" ng-controller="cobrosController">
    <div class="row">
      <div class="col-md-12">
        <div class="card hoverable">
          <div class="card-header main-color ch-alt">
            <h2>Cobros</h2>
          </div>
          <form class="form-horizontal">
            <div class="card-body card-padding">
              <input type="hidden" value="{{ csrf_token() }}" id="_token">
              <!-- Cobranza de alumno -->
              <div ng-hide="cobranzaAlumno || cobranzaExtraordinaria" class="animate-hide">
                <div class="form-group">
                  <label for="codigo_cobro" class="control-label col-sm-3">Ingrese código:</label>
                  <div class="col-sm-9">
                    <div class="fg-line">
                      <input type="text" class="form-control" id="codigo_cobro" name="codigo_cobro" placeholder="DNI de alumno o Código de pago" ng-model="cobro.codigo">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-3 col-sm-offset-9">
                    <button class="btn btn-block accent-color waves-effect" type="button" ng-click="buscar()" ng-disabled="buscando || !cobro.codigo">
                      <span ng-hide="buscando"><i class="zmdi zmdi-search"></i> Buscar</span>
                      <span ng-show="buscando">
                        <span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> Buscando...
                      </span>
                    </button>
                  </div>
                </div>
              </div>
              <div ng-show="cobranzaAlumno && !finalizando">
                <h3 class="text-uppercase m-t-0">{@ alumno.apellidos @}, {@ alumno.nombres @}</h3>
                <h4>{@ matricula_alumno @}</h4>
                <div class="table-responsive">
                  <table class="table table-striped m-b-15">
                    <thead>
                      <tr class="accent-color">
                        <td colspan="3" class="text-uppercase text-center">Pagos Pendientes</td>
                      </tr>
                      <tr class="accent-color">
                        <td></td>
                        <td>Concepto</td>
                        <td>Monto</td>
                      </tr>
                      <tr class="search-row">
                        <th></th>
                        <th><input type="text" class="form-control table-input" placeholder="Buscar..." ng-model="busqueda.concepto"></th>
                        <th></th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr ng-repeat="deuda in deudas | filter : { nombre : busqueda.concepto } : filtroConcepto">
                        <td>
                          <div class="checkbox table-checkbox">
                            <label>
                              <input type="checkbox" ng-model="deuda.seleccionada">
                              <i class="input-helper"></i>Seleccionar
                            </label>
                          </div>
                        </td>
                        <td>{@ deuda.nombre @}</td>
                        <td>
                          <div ng-class="!deuda.monto_pagado?'has-error':''">
                            <input type="number" class="form-control table-input text-right" ng-disabled="!deuda.seleccionada" ng-model="deuda.monto_pagado" placeholder="Monto" max="{@ deuda.monto_cancelar @}" min="0">
                            <small class="help-block invalid">El monto debe ser mayor a 0 y menor o igual a {@ deuda.monto_cancelar @}.</small>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="panel-group" role="tablist" aria-multiselectable="true" data-collapse-color="amber">
                  <div class="panel panel-collapse">
                    <div class="panel-heading" role="tab" id="headingOne">
                      <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                          Conceptos adicionales
                        </a>
                      </h4>
                    </div>
                    <div id="collapseOne" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                      <div class="panel-body">
                        <div class="table-responsive">
                          <table class="table table-striped">
                            <thead>
                              <tr class="accent-color">
                                <td></td>
                                <td>Concepto</td>
                                <td>Cantidad</td>
                                <td>Monto Unit. (S/)</td>
                                <td>Total</td>
                              </tr>
                              <tr class="search-row">
                                <th></th>
                                <th><input type="text" class="form-control table-input" placeholder="Buscar..." ng-model="busqueda.categoria"></th>
                                <th></th>
                                <th></th>
                                <th></th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr ng-repeat="concepto in categorias | filter : { nombre : busqueda.categoria } : filtroCategoria">
                                <td>
                                  <div class="checkbox table-checkbox">
                                    <label>
                                      <input type="checkbox" ng-model="concepto.seleccionada" ng-change="actualizarConcepto(concepto)">
                                      <i class="input-helper"></i>
                                    </label>
                                  </div>
                                </td>
                                <td>{@ concepto.nombre @}</td>
                                <td>
                                  <div ng-class="concepto.seleccionada && !concepto.cantidad?'has-error':''">
                                    <input type="number" class="form-control table-input text-right" ng-model="concepto.cantidad" ng-change="calcularTotal(concepto)" ng-disabled="!concepto.seleccionada" placeholder="Cantidad" min="0">
                                    <small class="help-block invalid">La cantidad debe ser mayor a 0.</small>
                                  </div>
                                </td>
                                <td class="text-right">{@ concepto.monto @}</td>
                                <td class="text-right">{@ concepto.total | number:2 @}</td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-3 col-sm-offset-6">
                    <button class="btn btn-block btn-link waves-effect" type="button" ng-click="cancelar()"><i class="zmdi zmdi-close-circle-o"></i> Cancelar</button>
                  </div>
                  <div class="col-sm-3">
                    <button class="btn btn-block main-color waves-effect" type="button" ng-click="finalizarCobro()" ng-disabled="!esValidoCobro()"><i class="zmdi zmdi-assignment-check"></i> Finalizar</button>
                  </div>
                </div>
              </div>
              <div ng-show="finalizando">
                <table class="table table-striped">
                  <thead>
                    <tr class="accent-color">
                      <td colspan="3" class="text-uppercase text-center">Resumen de Pago</td>
                    </tr>
                    <tr class="accent-color">
                      <td>Concepto</td>
                      <td>Monto</td>
                    </tr>
                  </thead>
                  <tbody>
                    <tr ng-repeat="pago in deudas_seleccionadas">
                      <td>{@ pago.nombre @}</td>
                      <td class="text-right">{@ pago.monto_pagado | number:2 @}</td>
                    </tr>
                    <tr ng-repeat="concepto in conceptos_adicionales">
                      <td>{@ concepto.nombre @}</td>
                      <td class="text-right">{@ concepto.total | number:2 @}</td>
                    </tr>
                  </tbody>
                  <tfoot>
                    <tr>
                      <td class="text-right"><strong>Total:</strong></td>
                      <td class="text-right">{@ totalPago() | number:2 @}</td>
                    </tr>
                  </tfoot>
                </table>
                <div class="form-group">
                  <div class="col-sm-3 col-sm-offset-3">
                    <button class="btn btn-block btn-link waves-effect" type="button" ng-click="cancelar()"><i class="zmdi zmdi-close-circle-o"></i> Cancelar</button>
                  </div>
                  <div class="col-sm-3">
                    <button class="btn btn-block accent-color waves-effect" type="button" ng-click="regresarAConceptos()"><i class="zmdi zmdi-chevron-left"></i> Regresar</button>
                  </div>
                  <div class="col-sm-3">
                    <button class="btn btn-block main-color waves-effect" type="button" ng-click="datosComprobante()"><i class="zmdi zmdi-assignment-check"></i> Confirmar</button>
                  </div>
                </div>
              </div>
              <!--/ Cobranza de alumno -->
              <!-- Cobranza extraordinaria -->
              <div ng-show="cobranzaExtraordinaria">
                <div class="form-group">
                  <label for="" class="control-label col-md-4">Cliente:</label>
                  <div class="col-md-8">
                    <p class="form-control-static">{@ deuda_extraordinaria.cliente_extr @}</p>
                  </div>
                </div>
                <div class="form-group">
                  <label for="" class="control-label col-md-4">Concepto:</label>
                  <div class="col-md-8">
                    <p class="form-control-static">{@ deuda_extraordinaria.descripcion_extr @}</p>
                  </div>
                </div>
                <div class="form-group">
                  <label for="" class="control-label col-md-4">Monto:</label>
                  <div class="col-md-8">
                    <p class="form-control-static">{@ deuda_extraordinaria.saldo | number:2 @}</p>
                  </div>
                </div>
                <div class="form-group">
                  <label for="tipo_comprobante" class="control-label col-sm-4">Tipo de Comprobante</label>
                  <div class="col-sm-8">
                    <div class="fg-line">
                      <div class="select">
                        <select name="tipo_comprobante" id="tipo_comprobante" class="form-control" ng-model="comprobante.tipo" ng-change="cargarSeries()">
                          <option value="" disabled="">-- Seleccione Tipo de Comprobante --</option>
                          <option value="comprobante">Comprobante</option>
                          <option value="boleta" ng-disabled="destino_externo">Boleta</option>
                          <option value="factura" ng-disabled="destino_externo">Factura</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="serie_comprobante" class="control-label col-sm-4">Serie de Comprobante</label>
                  <div class="col-sm-8">
                    <div class="fg-line">
                      <div class="select">
                        <select name="serie_comprobante" id="serie_comprobante" class="form-control" ng-options="comprobante_aux.serie as comprobante_aux.serie for comprobante_aux in comprobantes" ng-model="comprobante.serie" ng-change="cargarNumero()">
                          <option value="" disabled="">-- Seleccione Serie --</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="numero_comprobante" class="control-label col-sm-4">Número de Comprobante</label>
                  <div class="col-sm-8">
                    <div class="fg-line">
                      <input type="text" ng-model="comprobante.numero" class="form-control">
                    </div>
                  </div>
                </div>
                <hr>
                <div ng-show="comprobante.tipo == 'factura'">
                  <div class="form-group">
                    <label for="ruc" class="control-label col-sm-4">RUC</label>
                    <div class="col-sm-8">
                      <div class="fg-line">
                        <input type="text" ng-model="comprobante.ruc" class="form-control">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="razon_social" class="control-label col-sm-4">Razón Social</label>
                    <div class="col-sm-8">
                      <div class="fg-line">
                        <input type="text" ng-model="comprobante.razon_social" class="form-control">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="direccion" class="control-label col-sm-4">Dirección</label>
                    <div class="col-sm-8">
                      <div class="fg-line">
                        <input type="text" ng-model="comprobante.direccion" class="form-control">
                      </div>
                    </div>
                  </div>
                  <hr>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-4">Pagó con</label>
                  <div class="col-sm-8">
                    <div class="fg-line">
                      <input type="number" class="form-control text-right f-20" ng-model="efectivo" ng-change="calcularVueltoExtraordinario()">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-4">Vuelto</label>
                  <div class="col-sm-8">
                    <div class="fg-line">
                      <input type="text" class="form-control text-right f-20" ng-model="vuelto" disabled="disabled">
                    </div>
                  </div>
                </div>
                <div class="form-group m-t-15">
                  <div class="col-sm-3 col-sm-offset-6">
                    <button class="btn btn-block btn-link waves-effect" type="button" ng-click="cancelar()"><i class="zmdi zmdi-close-circle-o"></i> Cancelar</button>
                  </div>
                  <div class="col-sm-3">
                    <button class="btn btn-block main-color waves-effect" type="button" ng-click="finalizarCobroExtraordinario()" ng-disabled="!esValidoDatosComprobante()"><i class="zmdi zmdi-assignment-check"></i> Finalizar Cobro</button>
                  </div>
                </div>
              </div>
              <!--/ Cobranza extraordinaria -->
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- modal -->
    <div class="modal fade" id="modal-resumen-pago" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Datos del Comprobante</h4>
            <hr>
            <form action="" class="form-horizontal">
              <div class="modal-body">
                <div class="form-group">
                  <label for="tipo_comprobante" class="control-label col-sm-4">Tipo de Comprobante</label>
                  <div class="col-sm-8">
                    <div class="fg-line">
                      <div class="select">
                        <select name="tipo_comprobante" id="tipo_comprobante" class="form-control" ng-model="comprobante.tipo" ng-change="cargarSeries()">
                          <option value="" disabled="">-- Seleccione Tipo de Comprobante --</option>
                          <option value="comprobante">Comprobante</option>
                          <option value="boleta" ng-disabled="destino_externo">Boleta</option>
                          <option value="factura" ng-disabled="destino_externo">Factura</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="serie_comprobante" class="control-label col-sm-4">Serie de Comprobante</label>
                  <div class="col-sm-8">
                    <div class="fg-line">
                      <div class="select">
                        <select name="serie_comprobante" id="serie_comprobante" class="form-control" ng-options="comprobante_aux.serie as comprobante_aux.serie for comprobante_aux in comprobantes" ng-model="comprobante.serie" ng-change="cargarNumero()">
                          <option value="" disabled="">-- Seleccione Serie --</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="numero_comprobante" class="control-label col-sm-4">Número de Comprobante</label>
                  <div class="col-sm-8">
                    <div class="fg-line">
                      <input type="text" ng-model="comprobante.numero" class="form-control">
                    </div>
                  </div>
                </div>
                <hr>
                <div ng-show="comprobante.tipo == 'factura'">
                  <div class="form-group">
                    <label for="ruc" class="control-label col-sm-4">RUC</label>
                    <div class="col-sm-8">
                      <div class="fg-line">
                        <input type="text" ng-model="comprobante.ruc" class="form-control">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="razon_social" class="control-label col-sm-4">Razón Social</label>
                    <div class="col-sm-8">
                      <div class="fg-line">
                        <input type="text" ng-model="comprobante.razon_social" class="form-control">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="direccion" class="control-label col-sm-4">Dirección</label>
                    <div class="col-sm-8">
                      <div class="fg-line">
                        <input type="text" ng-model="comprobante.direccion" class="form-control">
                      </div>
                    </div>
                  </div>
                  <hr>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-4">Total</label>
                  <div class="col-sm-8">
                    <div class="fg-line">
                      <input type="text" value="{@ totalPago() | number:2 @}" class="form-control text-right f-20" disabled="disabled">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-4">Pagó con</label>
                  <div class="col-sm-8">
                    <div class="fg-line">
                      <input type="number" class="form-control text-right f-20" ng-model="efectivo" ng-change="calcularVuelto()">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-4">Vuelto</label>
                  <div class="col-sm-8">
                    <div class="fg-line">
                      <input type="text" class="form-control text-right f-20" ng-model="vuelto" disabled="disabled">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-4 col-sm-offset-4">
                    <a class="btn btn-link btn-block waves-effect" data-dismiss="modal"><i class="zmdi zmdi-close-circle-o"></i> Cerrar</a>
                  </div>
                  <div class="col-sm-4">
                    <button class="btn btn-block main-color waves-effect" type="button" ng-click="grabarPago()" ng-disabled="!esValidoDatosComprobante()"><i class="zmdi zmdi-assignment-check"></i> Finalizar Cobro</button>
                  </div>
                </div>
              </div>
            </form>
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
