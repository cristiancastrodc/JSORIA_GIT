@extends('layouts.dashboard')

@section('title')
  Reporte de Egresos agrupados por Rubro
@endsection

@section('content')
  <h1>REPORTE DE EGRESOS AGRUPADOS POR RUBRO</h1>

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
          {!!Form::open(['route' => 'admin.reportes.EgresosRubro.procesar.store','class' => 'form-horizontal', 'method' => 'POST'])!!}
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
                <button type="submit" class="btn btn-warning waves-effect" id="btn-reporte-EgresosRubro">Generar</button>
              </div>
            </div>
          {!!Form::close()!!}
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script src="{{ asset('js/secretaria.js') }}"></script>
@endsection