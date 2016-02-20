@extends('layouts.dashboard')

@section('title')
  Administrar Otros Cobros
@endsection

@section('styles')
  {!!Html::style('vendors/bootgrid/jquery.bootgrid.min.css')!!}
@endsection

@section('content')
  <h1>ADMINISTRAR OTROS COBROS</h1>

  @if(Session::has('message'))
    <div class="alert alert-success alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      {{Session::get('message')}}
    </div>
  @endif

  @include('messages.errors')

  <div class="row">
    <div class="col-md-5">
      <div class="card">
        <div class="card-header">
          <h2>Nuevo Cobro</h2>
        </div>
        <div class="card-body card-padding">
          {!!Form::open(array('route' => 'admin.cobros.otros.store', 'class' => 'form-horizontal', 'method' => 'POST'))!!}
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
                <label for="nombre" class="col-sm-3 control-label">Concepto</label>
                <div class="col-sm-9">
                    <div class="fg-line">
                        <input type="text" class="form-control input-sm" id="nombre" name="nombre" placeholder="Concepto">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="monto" class="col-sm-3 control-label">Monto</label>
                <div class="col-sm-9">
                    <div class="fg-line">
                        <input type="text" class="form-control input-sm" id="monto" name="monto" placeholder="Monto">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="exterior">
                            <i class="input-helper"></i>
                            Cuenta exterior privada
                            <p><small> Marque esta casilla para almacenar los ingresos por ese concepto en la cuenta exterior privada de la corporación</small></p>
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12">
                    <div class="toggle-switch">
                        <label for="habilitado" class="ts-label">Habilitado</label>
                        <input id="habilitado" name="habilitado" type="checkbox" hidden="hidden">
                        <label for="habilitado" class="ts-helper"></label>
                    </div>
                </div>
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-warning pull-right waves-effect">Guardar</button>
            </div>
          {!!Form::close()!!}
        </div>
      </div>
    </div>
    <div class="col-md-7">
      <div class="card">
        <div class="card-header">
          <h2>Lista de Otros Cobros</h2>
          {!!Form::open(array('route' => 'admin.cobros.otros.store', 'class' => 'form-horizontal', 'method' => 'POST'))!!}
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
              <button type="submit" class="btn btn-primary waves-effect pull-right">Buscar</button>
            </div>
          {!!Form::close()!!}
        </div>
        <div class="card-body card-padding">
          <div class="table-responsive">
            <table id="data-table-basic" class="table table-striped">
                <thead>
                    <tr>
                        <th data-column-id="id" data-visible="false" data-identifier="true">Id</th>
                        <th data-column-id="Concepto" class="warning c-white">Concepto</th>
                        <th data-column-id="Monto" class="warning c-white">Monto</th>
                        <th data-column-id="Tipo" class="warning c-white">Estado</th>
                        <th data-column-id="Acciones" data-formatter="commands" data-sortable="false">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>1</td>
                    <td>Constancia Estudios Colegio</td>
                    <td>100.00</td>
                    <td>Deshabilitado</td>
                  </tr>
                </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  {!!Html::script('vendors/bootgrid/jquery.bootgrid.updated.min.js')!!}
  {!!Html::script('js/own.scripts.js')!!}
  <script type="text/javascript">
      $(document).ready(function(){
          //Basic Example
          $("#data-table-basic").bootgrid({
              css: {
                  icon: 'zmdi icon',
                  iconColumns: 'zmdi-view-module',
                  iconDown: 'zmdi-expand-more',
                  iconRefresh: 'zmdi-refresh',
                  iconUp: 'zmdi-expand-less'
              },
              formatters: {
                  "commands": function(column, row) {
                      return "<button type=\"button\" class=\"btn btn-icon waves-effect btn-success waves-circle\" data-row-id=\"" + row.id + "\"><span class=\"zmdi zmdi-edit\"></span></button> " +
                          "<button type=\"button\" class=\"btn btn-icon btn-danger waves-effect waves-circle\" data-row-id=\"" + row.id + "\"><span class=\"zmdi zmdi-delete\"></span></button>";
                  }
              },
          });
        });
  </script>
@endsection
