@extends('layouts.dashboard')

@section('title')
  Administrar Cobros Extraordinarios
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

  <div class="row" ng-app="cobrosExtraordinarios">
    <div class="col-md-5">
      <div class="card hoverable">
        <div class="card-header main-color ch-alt">
          <h2>Crear Cobro Extraordinario</h2>
        </div>
        <div class="card-body card-padding">
          <div ng-controller="crearCobroExtraordinarioController">
            <form class="form-horizontal">
              <div class="form-group">
                <label for="id_institucion" class="col-sm-3 control-label">Institución</label>
                <div class="col-sm-9">
                  <select class="selectpicker" name="institucion" id="institucion" title='Elegir Institución' ng-model="institucion" ng-options="opt as opt.label for opt in instituciones">
                    <option value="" disabled="">-- Seleccione Institución --</option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="descripcion_extr" class="col-sm-3 control-label">Descripción:</label>
                <div class="col-sm-9">
                  <div class="fg-line">
                    <textarea class="form-control" rows="2" placeholder="Escriba la descripcion" name="descripcion_extr" ng-model="descripcion_extr"></textarea>
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
                <label for="cliente_extr" class="col-sm-3 control-label">Cliente:</label>
                <div class="col-sm-9">
                  <div class="fg-line">
                    <input type="text" class="form-control input-sm" id="cliente_extr" name="cliente_extr" placeholder="Ingrese el nombre del cliente" ng-model="cliente_extr">
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
                <div class="col-sm-6 col-sm-offset-6">
                  <button type="button" class="btn btn-block waves-effect m-t-15 accent-color" ng-click="guardarCobroExtraordinario()" ng-disabled="procesando">
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
          <h2>Listar Cobros Extraordinarios</h2>
        </div>
        <div class="card-body card-padding">
          {!!Form::open(array('class' => 'form-horizontal', 'id' => 'form-listar-c-otros'))!!}
            <div class="form-group">
              <label for="id_institucion" class="col-sm-3 control-label">Institución</label>
              <div class="col-sm-9">
                <select class="selectpicker" name="id_institucion" id="id_institucion_listar" title='Elegir Institución'>
                  <option value="1">I.E. J. Soria</option>
                  <option value="2">CEBA Konrad Adenahuer</option>
                  <option value="3">I.S.T. Urusayhua</option>
                  <option value="4">Universidad Privada Líder Peruana</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-4 col-sm-offset-8">
                <button type="button" class="btn btn-block accent-color waves-effect m-t-10" id="btn-listar-extraordinarios">Buscar</button>
              </div>
            </div>
          {!!Form::close()!!}
        </div>
      </div>
      <div class="card hoverable">
        <div class="card-body card-padding">
          <div class="table-responsive">
            <table id="tabla-listar-extraordinarios" class="table table-striped">
                <thead>
                    <tr>
                        <th class="accent-color c-white">Código</th>
                        <th class="accent-color c-white">Concepto</th>
                        <th class="accent-color c-white">Monto</th>
                        <th class="accent-color c-white">Estado</th>
                        <th class="accent-color c-white">Anular</th>
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

@section('scripts')
  <script src="{{ asset('js/admin.js') }}"></script>
  <script src="{{ asset('js/angular.min.js') }}"></script>
  <script src="{{ asset('js/apps/cobros.extraordinarios.administrar.js') }}"></script>
@endsection
