@extends('layouts.dashboard')

@section('title')
  Administrar Matrículas
@endsection

@section('content')
  <h1>ADMINISTRAR MATRÍCULAS</h1>

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
          <h2>Nueva Matrícula</h2>
        </div>
        <div class="card-body card-padding">
          {!! Form::open(array('class' => 'form-horizontal', 'id' => 'form-crear-matricula')) !!}
            <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
            <div class="form-group">
              <label for="id_institucion" class="col-sm-3 control-label">Institución</label>
              <div class="col-sm-9">
                {!! Form::select('id_institucion', array('1' => 'I.E. J. Soria', '2' => 'CEBA Konrad Adenahuer', '3' => 'I.S.T. Urusayhua', '4' => 'ULP'), null, ['id' => 'id_institucion', 'class' => 'selectpicker', 'title' => 'Seleccione']) !!}
              </div>
            </div>
            <div class="form-group">
                <label for="fecha_inicio" class="col-sm-3 control-label">Fecha Inicio</label>
                <div class="col-sm-9">
                    <div class="fg-line">
                        <div class="dtp-container fg-line">
                            <input type='text' class="form-control date-picker" placeholder="Fecha" name="fecha_inicio" id="fecha_inicio" autocomplete="off">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="fecha_fin" class="col-sm-3 control-label">Fecha Fin</label>
                <div class="col-sm-9">
                    <div class="fg-line">
                        <div class="dtp-container fg-line">
                            <input type='text' class="form-control date-picker" placeholder="Fecha" name="fecha_fin" id="fecha_fin" autocomplete="off">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="nombre" class="col-sm-3 control-label">Concepto</label>
                <div class="col-sm-9">
                    <div class="fg-line">
                        <input type="text" class="form-control input-sm" id="nombre" name="nombre" placeholder="Nombre" autocomplete="off">
                    </div>
                </div>
            </div>
            <div class="form-group">
              <div class="table-responsive">
                <table class="table table-bordered" id="tabla-crear-matricula">
                    <thead>
                        <tr>
                            <th class="hidden">Id</th>
                            <th class="warning c-white">...</th>
                            <th class="warning c-white">Monto (S/)</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
              </div>
            </div>
            <div class="form-group">
              <button class="btn btn-warning waves-effect pull-right" id="btn-crear-matricula">Guardar</button>
            </div>
          {!! Form::close() !!}
        </div>
      </div>
    </div>
    <div class="col-sm-7">
      <div class="card">
        <div class="card-header">
          <h2>Buscar Matrículas Habilitadas</h2>
        </div>
        <div class="card-body card-padding">
          <form class="form-horizontal" id="form-listar-matriculas">
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
              <label for="year" class="col-sm-3 control-label">Año</label>
              <div class="col-sm-9">
                <div class="fg-line">
                  <input type="text" class="form-control input-mask" data-mask="0000" placeholder="Año" id="year" name="year" autocomplete="off">
                </div>
              </div>
            </div>
            <div class="form-group">
              <button class="btn btn-primary waves-effect pull-right" id="btn-listar-matriculas">Buscar</button>
            </div>
          </form>
        </div>
      </div>
      <div class="card">
        <div class="card-body card-padding">
          {!! Form::open(array('id' => 'form-deshabilitar-matriculas', 'class' => 'form-horizontal')) !!}
            <input type="hidden" id="token-deshabilitar" value="{{ csrf_token() }}">
            <div class="form-group">
              <div class="table-responsive">
                <table id="tabla-lista-matriculas" class="table table-striped">
                    <thead>
                        <tr>
                            <th class="hidden">Id</th>
                            <th class="warning c-white">Nombre</th>
                            <th class="warning c-white">...</th>
                            <th class="warning c-white">Monto</th>
                            <th class="warning c-white">Acciones</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
              </div>
            </div>
            <div class="form-group">
              <button class="btn btn-icon-text btn-primary pull-right" id="btn-deshabilitar-matriculas"><i class="zmdi zmdi-block"></i> Deshabilitar seleccionadas</button>
            </div>
          {!! Form::close() !!}
        </div>
      </div>
    </div>
  </div>
@endsection

@section('modals')
  @include('layouts.modals.matricula')
@endsection

@section('scripts')
  <script src="{{ asset('vendors/bootgrid/jquery.bootgrid.updated.min.js')}}"></script>
  <script src="{{ asset('js/admin.js')}}"></script>
@endsection