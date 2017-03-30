@extends('layouts.dashboard')

@section('title')
  Administrar Otros Cobros
@endsection

@section('content')
  @if(Session::has('message'))
  <div class="row">
    <div class="col-sm-10">
      <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        {{ Session::get('message') }}
      </div>
    </div>
  </div>
  @endif

  @include('messages.errors')

  <div class="row" ng-app="otrosCobros">
    <div class="col-md-5">
      <div class="card hoverable">
        <div class="card-header main-color ch-alt">
          <h2>Nuevo Cobro</h2>
        </div>
        <div class="card-body card-padding">
          <div ng-controller="crearOtroCobroController">
            <form class="form-horizontal">
              <div class="form-group">
                <label for="id_institucion" class="col-sm-3 control-label">Institución</label>
                <div class="col-sm-9">                  
                   <div class="fg-line">
                    <div class="select">
                      <select class="form-control" id="institucion" ng-options="institucion.nombre for institucion in instituciones" ng-model="institucion">
                        <option value="" disabled="">-- SELECCIONE INSTITUCIÓN --</option>
                      </select>
                    </div>
                  </div>
                </div>                
              </div>
              <div class="form-group">
                <label for="nombre" class="col-sm-3 control-label">Concepto</label>
                <div class="col-sm-9">
                  <div class="fg-line">
                    <input type="text" class="form-control input-sm" id="nombre" name="nombre" placeholder="Concepto" ng-model="nombre">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="monto" class="col-sm-3 control-label">Monto</label>
                <div class="col-sm-9">
                  <div class="fg-line">
                    <input type="text" class="form-control input-sm" id="monto" name="monto" placeholder="Monto" ng-model="monto">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-12">
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" name="exterior" ng-model="destino">
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
                    <input id="habilitado" name="habilitado" type="checkbox" hidden="hidden" ng-model="estado">
                    <label for="habilitado" class="ts-helper"></label>
                  </div>
                </div>
              </div>
              <div class="form-group m-t-15">
                <div class="col-md-5 col-md-offset-2">
                  <button class="btn btn-block btn-link waves-effect" type="button" ng-click="inicializar()">Cancelar</button>
                </div>
                <div class="col-sm-5">
                  <button type="button" class="btn btn-block waves-effect  accent-color" ng-click="guardarOtroCobro()" ng-disabled="procesando">
                    <span ng-hide="procesando">Guardar</span>
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
    </div>
    <div class="col-md-7">
      <div class="card hoverable">
        <div class="card-header main-color ch-alt">
          <h2>Lista de Otros Cobros</h2>
        </div>
        <div class="card-body card-padding">
          {!!Form::open(array('class' => 'form-horizontal', 'id' => 'form-listar-c-otros'))!!}
            <div class="form-group">
              <label for="id_institucion" class="col-sm-3 control-label">Institución</label>
              <div class="col-sm-9">
                <select class="selectpicker" name="id_institucion" id="id_institucion" title='Elegir Institución'>
                  <option value="1">I.E. J. Soria</option>
                  <option value="2">CEBA Konrad Adenahuer</option>
                  <option value="3">I.S.T. Urusayhua</option>
                  <option value="4">Universidad Privada Líder Peruana</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-4 col-sm-offset-8">
                <button class="btn btn-block accent-color waves-effect m-t-10" id="btn-listar-c-otros">Buscar</button>
              </div>
            </div>
          {!!Form::close()!!}
        </div>
      </div>
      <div class="card hoverable">
        <div class="card-body card-padding">
          <div class="table-responsive">
            <table id="tabla-listar-c-otros" class="table table-striped">
                <thead>
                    <tr>
                        <th class="hidden">Id</th>
                        <th class="accent-color c-white">Concepto</th>
                        <th class="accent-color c-white">Monto</th>
                        <th class="accent-color c-white">Estado</th>
                        <th class="accent-color c-white">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('modals')
  @include('layouts.modals.c-otro')
@endsection

@section('scripts')
  <script src="{{ asset('js/admin.js') }}"></script>
  <script src="{{ asset('js/angular.min.js') }}"></script>
  <script src="{{ asset('js/apps/cobros.otros.administrar.js') }}"></script>
@endsection
