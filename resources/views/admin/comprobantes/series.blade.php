@extends('layouts.dashboard')

@section('title')
  Definir Comprobantes
@endsection

@section('content')
  @if(Session::has('message'))
  <div class="row">
    <div class="col-sm-12">
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

  <div class="row" ng-app="administrarComprobantes" ng-controller="comprobantesController">
    <div class="col-sm-6">
      <div class="card hoverable">
        <div class="card-header main-color ch-alt">
          <h2>Definir Comprobantes</h2>
        </div>
        <div class="card-body card-padding">
          <form action="{{ url('admin/comprobante/guardar') }}" class="form-horizontal" method="POST">
            <input type="hidden" value="{{ csrf_token() }}" name="_token">
            <div class="form-group">
              <label for="tipo_comprobante" class="control-label col-sm-3">Tipo:</label>
              <div class="col-sm-9">
                <select name="tipo_comprobante" id="tipo_comprobante" class="selectpicker" title="Seleccione tipo de Comprobante">
                  <option value="comprobante">Comprobante</option>
                  <option value="boleta">Boleta</option>
                  <option value="factura">Factura</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="serie_comprobante" class="control-label col-sm-3">Serie</label>
              <div class="col-sm-9">
                <div class="fg-line">
                  <input type="text" id="serie_comprobante" name="serie_comprobante" class="form-control" placeholder="Serie">
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="numero_comprobante" class="control-label col-sm-3">Número</label>
              <div class="col-sm-9">
                <div class="fg-line">
                  <input type="text" id="numero_comprobante" name="numero_comprobante" class="form-control" placeholder="Número actual">
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="id_institucion" class="control-label col-sm-3">Institución</label>
              <div class="col-sm-9">
                <select name="id_institucion" id="id_institucion" class="selectpicker" title="Seleccione Institución">
                  <option value="1">I.E. J. Soria</option>
                  <option value="2">CEBA Konrad Adenauer</option>
                  <option value="3">I.S.T. Urusayhua</option>
                  <option value="4">Universidad Privada Líder Peruana</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-3 col-sm-offset-9">
                <button type="submit" class="btn btn-block waves-effect m-t-15 accent-color">
                  Guardar
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="col-sm-6">
      <div class="card hoverable">
        <div class="card-header main-color ch-alt">
          <h2>Comprobantes</h2>
        </div>
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th class="c-white accent-color">Institución</th>
                <th class="c-white accent-color">Tipo</th>
                <th class="c-white accent-color">Serie</th>
                <th class="c-white accent-color">Número</th>
              </tr>
            </thead>
            <tbody>
              <tr ng-repeat="comprobante in comprobantes">
                <td>{@ comprobante.nombre @}</td>
                <td>{@ comprobante.tipo @}</td>
                <td>{@ comprobante.serie @}</td>
                <td>{@ comprobante.numero_comprobante @}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script src="{{ asset('js/angular.min.js') }}"></script>
  <script src="{{ asset('js/apps/comprobantes.administrar.js') }}"></script>
@endsection
