@extends('layouts.dashboard')

@section('title')
  Registrar Egreso
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

  <div class="row">
    <div class="col-md-12">
      <div class="card hoverable">
        <div class="card-header main-color ch-alt">
          <h2>Nuevo Egreso</h2>
        </div>
        <form class="form-horizontal" id="form-registrar-egreso-tesorera">
          <div class="card-body card-padding">
            <input type="hidden" name="_token" value="{{csrf_token()}}" id="_token">
            <div class="form-group">
              <label for="id_institucion" class="col-sm-3 control-label">Institución</label>
              <div class="col-sm-9">
                <select class="selectpicker" name="id_institucion" id="id_institucion" title="-- Seleccione Institución --">
                  <option value="" disabled="">-- Seleccione Institución --</option>
                  @foreach($permisos as $permiso)
                    <option value="{{ $permiso->id }}">{{ $permiso->nombre }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="tipo_comprobante" class="col-sm-3 control-label">Tipo de comprobante</label>
              <div class="col-sm-9">
                <select class="selectpicker" name="tipo_comprobante" id="tipo_comprobante" title="-- Seleccione Tipo de Comprobante --">
                  <option value="" disabled="">-- Seleccione Tipo de Comprobante --</option>
                  <option value="1">Boleta</option>
                  <option value="2">Factura</option>
                  <option value="3">Comprobante de Pago</option>
                  <option value="4">Comprobante de Egreso</option>
                  <option value="5">Recibo por Honorario</option>
                </select>
              </div>
            </div>
            <div class="form-group" id="form-group-nro-comprobante">
              <label for="numero_comprobante" class="col-sm-3 control-label">Número</label>
              <div class="col-sm-9">
                  <div class="fg-line">
                      <input type="text" class="form-control" id="numero_comprobante" name="numero_comprobante" placeholder="Número" autocomplete="off">
                  </div>
              </div>
            </div>
            <div class="form-group">
              <label for="fecha" class="col-sm-3 control-label">Fecha del Comprobante</label>
              <div class="col-sm-9">
                <div class="fg-line">
                  <div class="dtp-container fg-line">
                    <input type='text' class="form-control date-picker" placeholder="Elija la fecha" name="fecha_egreso" id="fecha_egreso">
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group" id="form-group-razon-social">
              <label for="razon_social" class="col-sm-3 control-label">Razon Social</label>
              <div class="col-sm-9">
                <div class="fg-line">
                  <input type="text" class="form-control" id="razon_social" name="razon_social" placeholder="Razon Social" autocomplete="off">
                </div>
              </div>
            </div>
            <div class="form-group" id="form-group-razon-social">
              <label for="responsable" class="col-sm-3 control-label">Responsable</label>
              <div class="col-sm-9">
                <div class="fg-line">
                  <input type="text" class="form-control" id="responsable" name="responsable" placeholder="Responsable" autocomplete="off">
                  </div>
              </div>
            </div>
            <div class="form-group">
              <div id="egreso">
                <h4>Añadir detalles de egreso</h4>
                <div class="col-sm-4">
                  <div class="fg-line">
                    <input type="text" class="form-control" placeholder="Descripción" id="descripcion_egreso">
                  </div>
                </div>
                <div class="col-sm-3">
                  <div class="fg-line">
                    <select name="rubro_egreso" id="rubro_egreso" class="selectpicker" data-live-search="true" placeholder="Egreso" title="-- Seleccione Rubro --">
                      <option value="" disabled="">-- Seleccione Rubro --</option>
                      @foreach($rubros as $rubro)
                        <option value="{{ $rubro->id }}">{{ $rubro->nombre }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="fg-line">
                    <input type="number" class="form-control text-right" placeholder="Monto" id="monto_egreso">
                  </div>
                </div>
                <div class="col-sm-3">
                  <button class="btn accent-color btn-block" id="btn-detalle-egreso-agregar"><i class="zmdi zmdi-plus"></i> Agregar</button>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-sm-6 col-sm-offset-6">
                  <div class="panel-group" role="tablist" aria-multiselectable="true" data-collapse-color="cyan">
                    <div class="panel panel-collapse">
                      <div class="panel-heading" role="tab" id="headingOne">
                        <h4 class="panel-title">
                          <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne" class="c-cyan">
                            Añadir Rubro
                          </a>
                        </h4>
                      </div>
                      <div id="collapseOne" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                        <div class="panel-body">
                          <div class="col-sm-8">
                            <div class="fg-line">
                              <input type="text" class="form-control" id="nombre-rubro" name="nombre" placeholder="Nombre">
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <button class="btn accent-color waves-effect btn-block" id="btn_nuevo_rubro"><i class="zmdi zmdi-plus"></i> Agregar</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table" id="tabla-resumen-egresos">
              <thead>
                <tr>
                  <th class="accent-color c-white">Descripcion</th>
                  <th class="accent-color c-white">Rubro</th>
                  <th class="accent-color c-white">Monto (S/)</th>
                  <th class="accent-color c-white">Acciones</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
          <div class="card-body card-padding">
            <div class="form-group">
              <div class="col-md-4 col-md-offset-4">
                <button class="btn btn-block btn-link waves-effect" type="button" id="btn-inicializar-crear-egreso"><i class="zmdi zmdi-close-circle-o"></i> Cancelar</button>
              </div>
              <div class="col-md-4">
                <button class="btn accent-color waves-effect btn-block" id="btn-guardar-egreso"><i class="zmdi zmdi-assignment-check"></i> Guardar</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script src="{{ asset('js/tesorera.js') }}"></script>
@endsection