@extends('layouts.dashboard')

@section('title')
  Administrar Rubros
@endsection

@section('styles')
  {!!Html::style('vendors/bootgrid/jquery.bootgrid.min.css')!!}
@endsection

@section('content')
  <h1>ADMINISTRAR RUBROS</h1>

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
          <h2>Nuevo Rubro</h2>
        </div>
        <div class="card-body card-padding">
          {!!Form::open(array('route' => 'tesorera.rubros.store', 'class' => 'form-horizontal', 'method' => 'POST'))!!}
            <div class="form-group">
              <label for="nombre" class="col-sm-3 control-label">Rubro</label>
              <div class="col-sm-9">
                  <div class="fg-line">
                      <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Rubro">
                  </div>
              </div>
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-warning waves-effect pull-right">Guardar</button>
            </div>
          {!!Form::close()!!}
        </div>
      </div>
    </div>


    <div class="col-md-7">
      <div class="card">
        <div class="card-header">
          <h2>Lista de Rubros</h2>
        </div>
        <div class="card-body card-padding">
          <div class="table-responsive">
            <table id="data-table-basic" class="table table-striped">
                <thead>
                    <tr>
                        <th data-column-id="id" data-visible="false">Id</th>
                        <th data-column-id="rubro" class="warning c-white">Rubro</th>
                        <th data-column-id="acciones" data-formatter="commands" data-sortable="false">Acciones</th>
                    </tr>
                </thead>
                <tbody>

                      @foreach ($rubros as $rubro) 
                        <tr>
                          <td>{{$rubro->id}}</td>
                          <td>{{$rubro->nombre}}</td> 
                        </tr>                      
                      @endforeach
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
                      return "<button type=\"button\" class=\"btn btn-icon waves-effect btn-primary\" data-row-id=\"" + row.id + "\" value=\"" + row.id + "\" OnClick='EditarRubro(this)'><span class=\"zmdi zmdi-edit\"></span></button> " +
                          "<button type=\"button\" class=\"btn btn-icon waves-effect btn-danger\" data-row-id=\"" + row.id + "\" value=\"" + row.id + "\" OnClick='EliminarRubro(this)'><span class=\"zmdi zmdi-delete\"></span></button>";
                  }
              },
          });
        });
  </script>
@endsection