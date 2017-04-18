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
          <div class="card-body card-padding">
            <form class="form-horizontal">
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
                        <span ng-hide="buscando">Buscar</span>
                        <span ng-show="buscando">
                          <span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> Buscando...
                        </span>
                      </button>
                    </div>
                  </div>
              </div>
              <div ng-show="cobranzaAlumno && !finalizando" class="animate-hide">
                <h3 class="text-uppercase m-t-0">{@ alumno.nombres @} {@ alumno.apellidos @}</h3>
                <h4>{@ matricula_alumno @}</h4>
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
                  </thead>
                  <tbody>
                    <tr ng-repeat="deuda in deudas">
                      <td>
                        <div class="checkbox table-checkbox">
                          <label>
                            <input type="checkbox" ng-model="deuda.seleccionada" value="{@ deuda.seleccionada @}">
                            <i class="input-helper"></i>Seleccionar
                          </label>
                        </div>
                      </td>
                      <td>{@ deuda.nombre @}</td>
                      <td>
                        <input type="text"  class="form-control table-input text-right" ng-disabled="!deuda.seleccionada" ng-model="deuda.monto_pagado">
                      </td>
                    </tr>
                  </tbody>
                </table>
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
                            </thead>
                            <tbody>
                              <tr ng-repeat="concepto in categorias">
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
                                  <input type="text" class="form-control table-input text-right" ng-model="concepto.cantidad" ng-change="calcularTotal(concepto)" ng-disabled="!concepto.seleccionada">
                                </td>
                                <td class="text-right">{@ concepto.monto @}</td>
                                <td class="text-right">{@ concepto.total @}</td>
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
                    <button class="btn btn-block btn-link waves-effect" type="button" ng-click="cancelar()">Cancelar</button>
                  </div>
                  <div class="col-sm-3">
                    <button class="btn btn-block main-color waves-effect" type="button" ng-click="finalizarCobro()">Finalizar</button>
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
                      <td class="text-right"><b>Total:</b></td>
                      <td class="text-right">{@ totalPago() | number:2 @}</td>
                    </tr>
                  </tfoot>
                </table>
                <div class="form-group">
                  <div class="col-sm-3 col-sm-offset-6">
                    <button class="btn btn-block btn-link waves-effect" type="button" ng-click="cancelar()">Cancelar</button>
                  </div>
                  <div class="col-sm-3">
                    <button class="btn btn-block main-color waves-effect" type="button" ng-click="datosComprobante()">Confirmar</button>
                  </div>
                </div>
              </div>
              <!--/ Cobranza de alumno -->
              <!-- Cobranza extraordinaria -->
              <div ng-show="cobranzaExtraordinaria">
                <table class="table table-striped">
                  <tr>
                    <td>Cliente:</td>
                    <td>{@ deuda_extraordinaria.cliente_extr @}</td>
                  </tr>
                  <tr>
                    <td>Concepto:</td>
                    <td>{@ deuda_extraordinaria.descripcion_extr @}</td>
                  </tr>
                  <tr>
                    <td>Monto:</td>
                    <td>S/ {@ deuda_extraordinaria.saldo | number:2 @}</td>
                  </tr>
                </table>
                <div class="form-group">
                  <label for="tipo_comprobante" class="control-label col-sm-4">Tipo de Comprobante</label>
                  <div class="col-sm-8">
                    <div class="fg-line">
                      <div class="select">
                        <select name="tipo_comprobante" id="tipo_comprobante" class="form-control" ng-model="tipo_comprobante" ng-change="cargarSeries()">
                          <option value="">Seleccione Tipo de Comprobante</option>
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
                        <select name="serie_comprobante" id="serie_comprobante" class="form-control" ng-options="comp.serie for comp in comprobantes" ng-model="comprobante"  ng-change="cargarNumeros()">
                          <option value="">Seleccione Serie</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="numero_comprobante" class="control-label col-sm-4">Número de Comprobante</label>
                  <div class="col-sm-8">
                    <div class="fg-line">
                      <input type="text" ng-model="comprobante.numero_comprobante" class="form-control">
                    </div>
                  </div>
                </div>
                <hr>
                <div ng-show="tipo_comprobante == 'factura'">
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
                      <input type="text" class="form-control text-right f-20" ng-model="efectivo" ng-change="calcularVueltoExtraordinario()">
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
                    <button class="btn btn-block btn-link waves-effect" type="button" ng-click="cancelar()">Cancelar</button>
                  </div>
                  <div class="col-sm-3">
                    <button class="btn btn-block main-color waves-effect" type="button" ng-click="finalizarCobroExtraordinario()">Finalizar Cobro</button>
                  </div>
                </div>
              </div>
              <!--/ Cobranza extraordinaria -->
            </form>
          </div>
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
                        <select name="tipo_comprobante" id="tipo_comprobante" class="form-control" ng-model="tipo_comprobante" ng-change="cargarSeries()">
                          <option value="">Seleccione Tipo de Comprobante</option>
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
                        <select name="serie_comprobante" id="serie_comprobante" class="form-control" ng-options="comp.serie for comp in comprobantes" ng-model="comprobante"  ng-change="cargarNumeros()">
                          <option value="">Seleccione Serie</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="numero_comprobante" class="control-label col-sm-4">Número de Comprobante</label>
                  <div class="col-sm-8">
                    <div class="fg-line">
                      <input type="text" ng-model="comprobante.numero_comprobante" class="form-control">
                    </div>
                  </div>
                </div>
                <hr>
                <div ng-show="tipo_comprobante == 'factura'">
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
                      <input type="text" class="form-control text-right f-20" ng-model="efectivo" ng-change="calcularVuelto()">
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
                    <a class="btn btn-link btn-block waves-effect" data-dismiss="modal">Cerrar</a>
                  </div>
                  <div class="col-sm-4">
                    <button class="btn btn-block main-color waves-effect" type="button" ng-click="grabarPago()">Finalizar Cobro</button>
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
