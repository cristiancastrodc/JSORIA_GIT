@extends('layouts.dashboard')

@section('title')
  Administrar Rubros
@endsection

@section('styles')
  {!!Html::style('vendors/bootgrid/jquery.bootgrid.min.css')!!}
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
    <div class="col-md-5">
      <div class="card hoverable">
        <div class="card-header main-color ch-alt">
          <h2>Crear Rubro</h2>
        </div>
        <div class="card-body card-padding">
          <form class="form-horizontal">
            <input type="hidden" value="{{ csrf_token() }}" id="_token">
            <div class="form-group">
              <label for="nombre" class="col-sm-3 control-label">Rubro</label>
              <div class="col-sm-9">
                  <div class="fg-line">
                      <input type="text" class="form-control" id="nombre_rubro" name="nombre" placeholder="Nombre del Rubro">
                  </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-6 col-sm-offset-6">
                <button class="btn btn-block accent-color waves-effect m-t-10" id="btn-crear-rubro">Guardar</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="col-md-7">
      <div class="card hoverable">
        <div class="card-header main-color ch-alt">
          <h2>Listar Rubros</h2>
        </div>
        <div class="card-body card-padding">
          <div class="table-responsive">
            {!! Form::open() !!}
            <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
            <table id="tabla-listar-rubro" class="table table-striped">
                <thead>
                    <tr>
                        <th class="accent-color c-white">Id</th>
                        <th class="accent-color c-white">Rubro</th>
                        <th class="accent-color c-white">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                  @foreach ($rubros as $rubro)
                    <tr>
                      <td class='rubro-id'>{{$rubro->id}}</td>
                      <td>{{$rubro->nombre}}</td>
                      <td>
                        <a href='#modal-editar-rubro' data-toggle='modal' class='btn bgm-amber' data-id="{{ $rubro->id }}" data-nombre="{{ $rubro->nombre }}"><i class='zmdi zmdi-edit'></i></a>
                        <a class="btn btn-danger waves-effect eliminar-rubro" data-toggle="tooltip" data-placement="top" data-original-title="Eliminar"><i class="zmdi zmdi-delete"></i></a>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
            </table>
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('modals')
  @include('layouts.modals.rubro')
@endsection

@section('scripts')
  <script src="{{ asset('vendors/bootstrap-growl/bootstrap-growl.min.js') }}"></script>
  <script src="{{ asset('js/tesorera.js') }}"></script>
@endsection