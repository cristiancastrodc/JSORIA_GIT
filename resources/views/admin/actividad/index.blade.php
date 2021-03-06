@extends('layouts.dashboard')

@section('title')
  Administrar Actividades
@endsection

@section('content')
  <h1>ADMINISTRAR ACTIVIDADES</h1>

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
          <h2>Crear Actividad</h2>
        </div>
        <div class="card-body card-padding">
          {!!Form::open(array('class' => 'form-horizontal', 'id' => 'form-crear-actividad'))!!}
          <input type="hidden" value="{{ csrf_token() }}" id="token" name="token">
            <div class="form-group">
              <label for="id_institucion" class="col-sm-3 control-label">Institución</label>
              <div class="col-sm-9">
                <select class="selectpicker" name="id_institucion" id="id_institucion" title='Seleccione'>
                  <option value="1">I.E. J. Soria</option>
                  <option value="2">CEBA Konrad Adenahuer</option>
                  <option value="3">I.S.T. Urusayhua</option>
                  <option value="4">ULP</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="nombre_division" class="col-sm-3 control-label"></label>
              <div class="col-sm-9">
                <select class="selectpicker" name="id_detalle_institucion" id="id_detalle_institucion" title='Seleccione'>
                </select>
              </div>
            </div>
            <div class="form-group">
                <label for="nombre" class="col-sm-3 control-label">Nombre</label>
                <div class="col-sm-9">
                  <div class="fg-line">
                      <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre">
                  </div>
                </div>
            </div>
            <div class="form-group">
                <label for="monto" class="col-sm-3 control-label">Monto</label>
                <div class="col-sm-9">
                  <div class="input-group">
                      <span class="input-group-addon">S/</span>
                      <div class="fg-line">
                        <input type="text" class="form-control" id="monto" name="monto" placeholder="Monto">
                      </div>
                  </div>
                </div>
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-warning waves-effect pull-right" id="btn-crear-actividad">Guardar</button>
            </div>
          {!!Form::close()!!}
        </div>
      </div>
    </div>
    <div class="col-md-7">
      <div class="card">
        <div class="card-header">
          <h2>Buscar Actividades</h2>
          {!!Form::open(array('class' => 'form-horizontal', 'id' => 'form-listar-actividades'))!!}
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
              <div class="col-sm-9 col-sm-offset-3">
                <select class="selectpicker" name="id_detalle_institucion" id="id_detalle_institucion" title='Elegir...'>
                </select>
              </div>
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-primary waves-effect pull-right" id="btn-listar-actividades">Buscar</button>
            </div>
          {!!Form::close()!!}
        </div>
        <div class="card-body card-padding">
          <div class="table-responsive">
            <table id="tabla-listar-actividades" class="table table-striped">
                <thead>
                    <tr>
                        <th class="hidden">Id</th>
                        <th class="warning c-white">Actividad</th>
                        <th class="warning c-white">Monto</th>
                        <th class="warning c-white">Acciones</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
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
@endsection