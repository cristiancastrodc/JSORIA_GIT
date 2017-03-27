@extends('layouts.dashboard')

@section('title')
  Administrar Actividades
@endsection

@section('content')
  @if(Session::has('message'))
    <div class="row">
      <div class="col-sm-10">
        <div class="alert alert-success alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          {{Session::get('message')}}
        </div>
      </div>
    </div>
  @endif

  @include('messages.errors')

  <div ng-app="administrarActividades" ng-controller="actividadesController">
    <div class="row">
      <div class="col-md-6">
        <div class="card hoverable">
          <div class="card-header main-color ch-alt">
            <h2>Crear Actividad</h2>
          </div>
          <div class="card-body card-padding">
            <form class="form-horizontal">
              <div class="form-group">
                <label for="institucion" class="col-sm-3 control-label">Institución</label>
                <div class="col-sm-9">
                  <div class="fg-line">
                    <div class="select">
                      <select class="form-control" id="institucion" ng-options="institucion.nombre for institucion in instituciones" ng-model="actividad.institucion" ng-change="cargarDetalle()" ng-disabled="actividad.todas_instituciones">
                        <option value="" disabled="">-- SELECCIONE INSTITUCIÓN --</option>
                      </select>
                    </div>
                  </div>
                  <!-- div class="checkbox">
                    <label>
                      <input type="checkbox" id="todas_instituciones" ng-model="actividad.todas_instituciones">
                      <i class="input-helper"></i>
                      Todas las instituciones
                    </label>
                  </div-->
                </div>
              </div>
              <div class="form-group">
                <label for="division" class="control-label col-sm-3">{@ labels.division @}</label>
                <div class="col-sm-9">
                  <div class="fg-line">
                    <div class="select">
                      <select class="form-control" id="division" ng-options="division.nombre_division for division in divisiones" ng-model="actividad.division" ng-disabled="actividad.todas_instituciones || actividad.todas_divisiones">
                        <option value="">-- Seleccione {@ labels.division @} --</option>
                      </select>
                    </div>
                  </div>
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" id="todas_divisiones" ng-model="actividad.todas_divisiones">
                      <i class="input-helper"></i>
                      {@ labels.todas_divisiones @}
                    </label>
                  </div>
                </div>
              </div>
              <div class="form-group">
                  <label for="nombre" class="col-sm-3 control-label">Nombre</label>
                  <div class="col-sm-9">
                    <div class="fg-line">
                        <input type="text" class="form-control" id="nombre" placeholder="Nombre de la Actividad" ng-model="actividad.nombre">
                    </div>
                  </div>
              </div>
              <div class="form-group">
                  <label for="monto" class="col-sm-3 control-label">Monto</label>
                  <div class="col-sm-9">
                    <div class="input-group">
                        <span class="input-group-addon">S/</span>
                        <div class="fg-line">
                          <input type="text" class="form-control" id="monto" placeholder="Monto de la Actividad" ng-model="actividad.monto">
                        </div>
                    </div>
                  </div>
              </div>
              <div class="form-group">
                <div class="col-md-4 col-md-offset-4">
                  <button class="btn btn-block btn-link waves-effect" type="button" ng-click="inicializar()">Cancelar</button>
                </div>
                <div class="col-sm-4">
                  <button type="button" class="btn btn-block accent-color waves-effect" ng-click="grabarActividad()" ng-disabled="procesando">
                    <span ng-hide="procesando">Grabar</span>
                    <span ng-show="procesando">
                      <span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> Procesando...
                    </span>
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card hoverable">
          <div class="card-header main-color ch-alt">
            <h2>Buscar Actividades</h2>
          </div>
          <div class="card-header">
            {!!Form::open(array('class' => 'form-horizontal', 'id' => 'form-listar-actividades'))!!}
              <div class="form-group">
                <label for="id_institucion" class="col-sm-3 control-label">Institución</label>
                <div class="col-sm-9">
                  <select class="selectpicker" name="id_institucion" id="id_institucion" title='Elegir Institución'>
                    <option value="1">I.E. J. Soria</option>
                    <option value="2">CEBA Konrad Adenahuer</option>
                    <option value="3">I.S.T. Urusayhua</option>
                    <option value="4">ULP</option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-9 col-sm-offset-3">
                  <select class="selectpicker" name="id_detalle_institucion" id="id_detalle_institucion" title='Elegir Nivel o Carrera'>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-4 col-sm-offset-8">
                  <button class="btn btn-block accent-color waves-effect m-t-10" id="btn-listar-actividades">Buscar</button>
                </div>
              </div>
            {!!Form::close()!!}
          </div>
          <div class="card-body card-padding">
            <div class="table-responsive">
              <table id="tabla-listar-actividades" class="table table-striped">
                  <thead>
                      <tr>
                          <th class="hidden">Id</th>
                          <th class="c-white accent-color">Actividad</th>
                          <th class="c-white accent-color">Monto</th>
                          <th class="c-white accent-color">Acciones</th>
                      </tr>
                  </thead>
                  <tbody></tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('modals')
  @include('layouts.modals.actividad')
@endsection

@section('scripts')
  <script src="{{ asset('vendors/bootstrap-growl/bootstrap-growl.min.js') }}"></script>
  <script src="{{ asset('js/admin.js') }}"></script>
  <script src="{{ asset('js/angular.min.js') }}"></script>
  <script src="{{ asset('js/apps/actividades.administrar.js') }}"></script>
@endsection