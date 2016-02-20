@extends('layouts.dashboard')

@section('title')
  Cancelar deuda de actividad
@endsection

@section('styles')
  {!!Html::style('vendors/bootgrid/jquery.bootgrid.min.css')!!}
@endsection

@section('content')
  <h1>CANCELAR DEUDA DE ACTIVIDAD</h1>

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
              <label for="dni" class="col-sm-3 control-label">DNI</label>
              <div class="col-sm-9">
                  <div class="fg-line">
                      <input type="text" class="form-control input-sm" id="dni" name="dni" placeholder="DNI">
                  </div>
              </div>
            </div>
            <div class="form-group">
              <div class="pull-right">
                <button class="btn btn-warning waves-effect">Buscar</button>
              </div>
            </div>
          {!!Form::close()!!}
        </div>
      </div>
      <div class="card">
        <div class="card-body card-padding">
          <div class="table-responsive">
            <table id="data-table-basic" class="table table-striped">
                <thead>
                    <tr>
                        <th data-column-id="id" data-visible="false" data-identifier="true">Id</th>
                        <th data-column-id="Concepto" class="warning c-white">Concepto</th>
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
          <div class="form-group">
            <div class="pull-right">
              <button class="btn btn-warning waves-effect">Cancelar Deudas</button>
            </div>
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
              selection : true,
              multiSelect : true,
              rowSelect : true,
              keepSelection : true,
              navigation : 0,
          });
        });
  </script>
@endsection