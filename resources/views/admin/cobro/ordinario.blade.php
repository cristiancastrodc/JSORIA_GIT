@extends('layouts.dashboard')

@section('title')
  Administrar Cobros Ordinarios
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
          <h2>Nuevo Cobro</h2>
        </div>
        <div class="card-body card-padding">
          {!!Form::open(array('route' => 'admin.cobros.ordinarios.store', 'class' => 'form-horizontal', 'method' => 'POST'))!!}
            <div class="form-group">
              <label for="id_institucion" class="col-sm-3 control-label">Institución</label>
              <div class="col-sm-9">
                <select class="selectpicker" name="id_institucion" id="id_institucion" title='Elegir Institución'>
                  <option value="1">I.E. J. Soria</option>
                  <option value="2">CEBA Konrad Adenahuer</option>
                  <option value="3">I.S.T. Urusayhua</option>
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
                            <input type="checkbox" name="unitario">
                            <i class="input-helper"></i>
                            Convertir en Monto Unitario
                            <p><small> El monto Unitario permite agregar la cantidad a multiplicar para obtener el monto total</small></p>
                        </label>
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
              <div class="col-sm-6 col-sm-offset-6">
                <button class="btn btn-block accent-color waves-effect m-t-10">Guardar</button>
              </div>
            </div>
          {!!Form::close()!!}
        </div>
      </div>
    </div>
    <div class="col-md-7">
      <div class="card hoverable">
        <div class="card-header main-color ch-alt">
          <h2>Lista de Cobros Ordinarios</h2>
        </div>
        <div class="card-body card-padding">
          {!!Form::open(array('class' => 'form-horizontal', 'id' => 'form-lista-c-ordinarios'))!!}
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
              <div class="col-sm-4 col-sm-offset-8">
                <button class="btn btn-block accent-color waves-effect m-t-10" id="btn-lista-c-ordinarios">Buscar</button>
              </div>
            </div>
          {!!Form::close()!!}
        </div>
      </div>
      <div class="card hoverable">
        <div class="card-body card-padding">
          <div class="table-responsive">
            <table id="tabla-lista-c-ordinarios" class="table table-striped">
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
  @include('layouts.modals.c-ordinario')
@endsection

@section('scripts')
  <script src="{{ asset('js/admin.js') }}"></script>
@endsection
