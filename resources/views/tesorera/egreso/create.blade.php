@extends('layouts.dashboard')

@section('title')
  Registrar Egreso
@endsection

@section('content')
  <h1>REGISTRAR EGRESO</h1>

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
              <label for="id_institucion" class="col-sm-3 control-label">Institución</label>
              <div class="col-sm-9">
                <select class="selectpicker" name="id_institucion" id="id_institucion" title='Elegir...'>
                  <option value="1">I.E. J. Soria</option>
                  <option value="2">CEBA Konrad Adenahuer</option>
                  <option value="3">I.S.T. Urusayhua</option>
                  <option value="4">ULP</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="tipo_comprobante" class="col-sm-3 control-label">Tipo de comprobante</label>
              <div class="col-sm-9">
                <select class="selectpicker" name="tipo_comprobante" id="tipo_comprobante" title='Elegir...'>
                  <option>Boleta</option>
                  <option>Factura</option>
                  <option>Comprobante de Pago</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="numero_comprobante" class="col-sm-3 control-label">Número</label>
              <div class="col-sm-9">
                  <div class="fg-line">
                      <input type="text" class="form-control input-sm" id="numero_comprobante" name="numero_comprobante" placeholder="Número">
                  </div>
              </div>
            </div>
            <div class="form-group">
              <label for="fecha" class="col-sm-3 control-label">Fecha</label>
              <div class="col-sm-9">
                <div class="fg-line">
                  <div class="dtp-container fg-line">
                    <input type='text' class="form-control date-picker" placeholder="Elija la fecha" name="fecha" id="fecha">
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <h4>Añadir detalles de egreso</h4>
              <div class="col-sm-3">
                <div class="fg-line">
                  <input type="text" class="form-control" placeholder="Descripción" id="descripcion_egreso">
                </div>
              </div>
              <div class="col-sm-3">
                <div class="fg-line">
                  <select name="rubro_egreso" id="rubro_egreso" class="selectpicker" data-live-search="true" placeholder="Egreso" title="Rubro">
                    <option value="1">Movilidad</option>
                    <option value="2">Muebles</option>
                  </select>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="fg-line">
                  <input type="text" class="form-control" placeholder="Monto" id="monto_egreso">
                </div>
              </div>
              <div class="col-sm-3">
                <button class="btn btn-primary" id="add_egreso">Agregar</button>
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
                        <div id="collapseOne" class="collapse in" role="tabpanel" aria-labelledby="headingOne">
                            <div class="panel-body">
                              {!!Form::open(['class' => 'form-inline row'])!!}
                                <div class="col-sm-7">
                                  <div class="fg-line">
                                    <input type="text" class="form-control input-sm" id="nuevo_rubro" name="nuevo_rubro" placeholder="Nombre">
                                  </div>
                                </div>
                                <div class="col-sm-5">
                                  <button class="btn btn-primary waves-effect" id="btn_nuevo_rubro">Agregar</button>
                                </div>
                              {!!Form::close()!!}
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th class="hidden">Id</th>
                    <th class="warning c-white">Descripcion</th>
                    <th class="warning c-white">Rubro</th>
                    <th class="warning c-white">Monto (S/)</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="hidden">1</td>
                    <td>Impresora</td>
                    <td>Artículos</td>
                    <td>1000</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="form-group">
              <div class="pull-right">
                <a href="" class="btn btn-gray waves-effect c-black">Cancelar</a>
                <button class="btn btn-warning waves-effect">Guardar Egreso</button>
              </div>
            </div>
          {!!Form::close()!!}
        </div>
      </div>
    </div>
  </div>
@endsection