@extends('layouts.dashboard')

@section('title')
  Administrar Pensiones
@endsection

@section('content')
  <h1>ADMINISTRAR PENSIONES</h1>

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
          <h2>Nueva Pensión</h2>
        </div>
        <div class="card-body card-padding">
          {!! Form::open(array('class' => 'form-horizontal', 'id' => 'form-crear-pensiones')) !!}
            <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
            <div class="form-group">
              <label for="id_institucion" class="col-sm-3 control-label">Institución</label>
              <div class="col-sm-9">
                {!! Form::select('id_institucion', array('1' => 'I.E. J. Soria', '2' => 'CEBA Konrad Adenahuer', '3' => 'I.S.T. Urusayhua', '4' => 'ULP'), null, ['id' => 'id_institucion', 'class' => 'selectpicker', 'title' => 'Seleccione']) !!}
              </div>
            </div>
            <div class="form-group">
                <label for="mes_inicio" class="col-sm-3 control-label">Mes Inicial</label>
                <div class="col-sm-9">
                    <div class="fg-line">
                        <div class="dtp-container fg-line">
                            <input type='text' class="form-control month-picker" placeholder="Fecha" name="mes_inicio" id="mes_inicio" autocomplete="off">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="mes_fin" class="col-sm-3 control-label">Mes Final</label>
                <div class="col-sm-9">
                    <div class="fg-line">
                        <div class="dtp-container fg-line">
                            <input type='text' class="form-control month-picker" placeholder="Fecha" name="mes_fin" id="mes_fin" autocomplete="off">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
              <div class="table-responsive">
                <table class="table table-bordered" id="tabla-crear-pensiones">
                    <thead>
                        <tr>
                            <th class="hidden">Id</th>
                            <th class="warning c-white">División</th>
                            <th class="warning c-white">Monto (S/)</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
              </div>
            </div>
            <div class="form-group">
              <button class="btn btn-warning waves-effect pull-right" id="btn-crear-pensiones">Guardar</button>
            </div>
          {!! Form::close() !!}
        </div>
      </div>
    </div>
    <div class="col-md-7">
      <div class="card">
        <div class="card-header">
          <h2>Lista de Pensiones</h2>
          {!!Form::open(array('class' => 'form-horizontal', 'id' => 'form-listar-pensiones'))!!}
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
              <label for="year" class="col-sm-3 control-label">Año</label>
              <div class="col-sm-9">
                <div class="fg-line">
                  <input type="text" class="form-control input-mask" data-mask="0000" placeholder="Año" id="year" name="year" autocomplete="off">
                </div>
              </div>
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-primary waves-effect pull-right" id="btn-listar-pensiones">Buscar</button>
            </div>
          {!!Form::close()!!}
        </div>
        <div class="card-body card-padding">
          <div class="table-responsive">
            <table id="tabla-listar-pensiones" class="table table-striped">
                <thead>
                    <tr>
                        <th class="hidden">Id</th>
                        <th class="warning c-white">Concepto</th>
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
  @include('layouts.modals.pension')
@endsection

@section('scripts')
  <script src="{{ asset('js/admin.js') }}"></script>
@endsection
