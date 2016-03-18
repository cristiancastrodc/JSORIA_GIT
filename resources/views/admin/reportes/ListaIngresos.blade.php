@extends('layouts.dashboard')

@section('title')
  Reporte de Lista de Ingresos
@endsection

@section('content')
  <h1>REPORTE DE LISTA DE INGRESOS</h1>

  @if(Session::has('message'))
    <div class="alert alert-success alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      {{Session::get('message')}}
    </div>
  @endif

  @include('messages.errors')

  <div class="row">
    <div class="col-md-8">
      <div class="card">
        <div class="card-body card-padding">
         {!!Form::open(array('class' => 'form-horizontal', 'id' => 'form-reporte-ingresos','route' => 'admin.reportes.ListaIngresos.procesar.store','method' => 'POST'))!!}
            <input type="hidden" value="{{ csrf_token() }}" id="_token">
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
              <label for="id_institucion" class="col-sm-3 control-label">Categoria</label>
              <div class="col-sm-9">
                <select class="selectpicker" name="id_categoria" id="id_categoria" title='Seleccione'>
                  <option value="matricula">Matriculas</option>
                  <option value="pension">Pensiones</option>
                  <option value="actividad">Actividades</option>
                  <option value="cobro_extraordinario">Cobros Extraordinarios</option>
                  <option value="con_factor">Cobro Con Factor</option>
                  <option value="sin_factor">Cobro Sin Factor</option>
                  <option value="multiple">Otros cobros</option>
                </select>
                  <div class="col-sm-9 col-sm-3">
                      <div class="checkbox">
                          <label>
                              <input type="checkbox" name="todas_categorias" id="todas_categorias" class="input_control">
                              <i class="input-helper"></i>
                              Todos                              
                          </label>
                      </div>
                  </div>                
              </div>

            </div>

            <div class="form-group">
              <label for="fecha_inicio" class="col-sm-3 control-label">Fecha Inicial:</label>
                <div class="col-sm-9">
                    <div class="fg-line">
                        <div class="dtp-container fg-line">
                            <input type='text' class="form-control date-picker" placeholder="Fecha" name="fecha_inicio" id="fecha_inicio" autocomplete="off">
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
              <label for="fecha_fin" class="col-sm-3 control-label">Fecha Final:</label>
                <div class="col-sm-9">
                    <div class="fg-line">
                        <div class="dtp-container fg-line">
                            <input type='text' class="form-control date-picker" placeholder="Fecha" name="fecha_fin" id="fecha_fin" autocomplete="off">
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
              <div class="pull-right">
                <button type="submit" class="btn btn-warning waves-effect" id="btn-reporte-ListarIngreso" formtarget="_blank">Generar</button>
              </div>
            </div>
          {!!Form::close()!!}
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script src="{{ asset('js/reportes.js') }}"></script>
@endsection