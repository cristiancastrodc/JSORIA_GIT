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
    <div class="col-md-8">
      <div class="card">
        <div class="card-body card-padding">
          <div class="table-responsive">
            <table id="otros-conceptos" class="table table-striped">
              <thead>
                  <tr>
                      <th data-column-id="id" data-visible="false" data-identifier="true">Id</th>
                      <th data-column-id="Nombre" class="warning c-white">Nombre</th>
                      <th data-column-id="Monto" class="warning c-white">Monto</th>
                  </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1</td>
                  <td>Matrícula Colegio 2016</td>
                  <td>100.00</td>
                </tr>
                <tr>
                  <td>2</td>
                  <td>Matrícula CEBA 2016</td>
                  <td>100.00</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-body card-padding">
          {!!Form::open(['class' => 'form-horizontal'])!!}
            <div class="form-group">
              <div class="col-sm-2"><h4>Concepto:</h4></div>
              <div class="col-sm-8">Inscripción Examen de Admisión.</div>
              <div class="col-sm-2">S/ 100.00</div>
            </div>
            <div class="form-group">
                <label for="DNI" class="col-sm-3 control-label">DNI</label>
                <div class="col-sm-9">
                    <div class="fg-line">
                        <input type="text" class="form-control input-sm" id="DNI" name="DNI" placeholder="DNI">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="cliente_extr" class="col-sm-3 control-label">Nombre:</label>
                <div class="col-sm-9">
                    <div class="fg-line">
                        <input type="text" class="form-control input-sm" id="cliente_extr" name="cliente_extr" placeholder="Nombre">
                    </div>
                </div>
            </div>
            <div class="form-group">
              <div class="col-sm-12">
                <div class="pull-right">
                  <button class="btn btn-gray waves-effect">Cancelar</button>
                  <button class="btn bgm-green waves-effect">Comprobante</button>
                  <button class="btn bgm-indigo waves-effect">Boleta</button>
                  <button class="btn bgm-red waves-effect">Factura</button>
                </div>
              </div>
            </div>
          {!!Form::close()!!}
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
          $("#otros-conceptos").bootgrid({
              css: {
                  icon: 'zmdi icon',
                  iconColumns: 'zmdi-view-module',
                  iconDown: 'zmdi-expand-more',
                  iconRefresh: 'zmdi-refresh',
                  iconUp: 'zmdi-expand-less'
              },
              selection : true,
              multiSelect : true,
              rowSelect : true,
              keepSelection : true,
              navigation : 0,
          });
        });
  </script>
@endsection