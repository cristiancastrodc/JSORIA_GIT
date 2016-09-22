@extends('layouts.dashboard')

@section('title')
  Administrar Cobros Extraordinarios
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
    <div class="col-md-10">
      <div class="card hoverable">
        <div class="card-header main-color ch-alt">
          <h2>Crear Cobro Extraordinario</h2>
        </div>
        <div class="card-body card-padding">
          {!!Form::open(array('route' => 'admin.cobros.extraordinarios.store', 'class' => 'form-horizontal', 'method' => 'POST'))!!}
            <div class="form-group">
              <label for="id_institucion" class="col-sm-3 control-label">Institución</label>
              <div class="col-sm-9">
                <select class="selectpicker" name="id_institucion" id="id_institucion" title='Elegir...'>
                  <option value="1">I.E. J. Soria</option>
                  <option value="2">CEBA Konrad Adenahuer</option>
                  <option value="3">I.S.T. Urusayhua</option>
                  <option value="4">ULP</option>
                </select>
              </div>
            </div>
            <div class="form-group">
                <label for="descripcion_extr" class="col-sm-3 control-label">Descripción:</label>
                <div class="col-sm-9">
                    <div class="fg-line">
                        <textarea class="form-control" rows="2" placeholder="Escriba la descripcion" name="descripcion_extr"></textarea>
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
                <label for="cliente_extr" class="col-sm-3 control-label">Cliente:</label>
                <div class="col-sm-9">
                    <div class="fg-line">
                        <input type="text" class="form-control input-sm" id="cliente_extr" name="cliente_extr" placeholder="Ingrese el nombre del cliente">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-9 col-sm-offset-3">
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
              <div class="col-sm-3 col-sm-offset-9">
                <button class="btn btn-block accent-color waves-effect m-t-10">Guardar</button>
              </div>
            </div>
          {!!Form::close()!!}
        </div>
      </div>
    </div>
  </div>
@endsection