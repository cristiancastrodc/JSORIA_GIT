@extends('layouts.dashboard')

@section('title')
  Administrar Rubros
@endsection

@section('content')
  @if(Session::has('message'))
  <div class="row">
    <div class="col-sm-10">
      <div class="alert alert-{{ Session::get('message-class') }} alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        {{ Session::get('message') }}
      </div>
    </div>
  </div>
  @endif

  @include('messages.errors')

  <div ng-app="administrarRubro" ng-controller="rubroController">
    <div class="row">
      <div class="col-sm-10">
        <div class="card hoverable">
          <div class="card-header main-color ch-alt">
            <h2>Administrar Rubros</h2>
          </div>
          <div class="card-body card-padding">
            <form action="{{ url('/tesorera/administrar/rubros/crear') }}" class="form-horizontal" method="POST">
              <input type="hidden" value="{{ csrf_token() }}" name="_token">
              <div class="form-group">
                <label for="rubro" class="control-label col-sm-3">Rubro</label>
                <div class="col-sm-9">
                  <div class="fg-line">
                    <input type="text" class="form-control" id="rubro" name="rubro" ng-model = 'rubro'>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-4 col-md-offset-4">
                    <button class="btn btn-block btn-link waves-effect" type="button" ng-click="inicializar()"><i class="zmdi zmdi-close-circle-o"></i> Cancelar</button>
                  </div>
                <div class="col-sm-4">
                  <button type="submit" class="btn btn-block waves-effect accent-color"><i class="zmdi zmdi-assignment-check"></i> Crear</button>
                </div>
              </div>
            </form>
          </div>
          <table class="table table-bordered">
            <tr class="accent-color">
              <td>Rubro</td>
              <td>Acciones</td>
            </tr>
            @foreach($rubros as $rubro)
              <tr>
                <td>{{ $rubro->nombre }}</td>
                <td>
                  <span data-toggle="tooltip" data-placement="top" data-original-title="Editar">
                    <a href='#modal-editar-rubro' data-toggle='modal' class='btn third-color' data-id="{{ $rubro->id }}" data-nombre="{{ $rubro->nombre }}"><i class='zmdi zmdi-edit'></i></a>
                  </span>
                  <a href="{{ url('/tesorera/administrar/rubros/eliminar', [ $rubro->id ]) }}" class="btn fourth-color" data-toggle="tooltip" data-placement="top" data-original-title="Eliminar"><i class="zmdi zmdi-delete"></i></a>
                </td>
              </tr>
            @endforeach
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('modals')
  @include('layouts.modals.rubro')
@endsection

@section('scripts')
  <script src="{{ asset('js/tesorera/rubros.js') }}"></script>
  <script src="{{ asset('js/angular.min.js') }}"></script>
  <script src="{{ asset('js/apps/rubros.crear.js') }}"></script>
@endsection
