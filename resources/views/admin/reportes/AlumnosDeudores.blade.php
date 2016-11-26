@extends('layouts.dashboard')

@section('title')
  Reporte de Alumnos Deudores
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
    <div class="col-md-8">
      <div class="card hoverable">
        <div class="card-header main-color ch-alt">
          <h2>Reporte de Alumnos deudores</h2>
        </div>
        <div class="card-body card-padding">
          <form action="{{ url('/admin/reportes/AlumnosDeudores/procesar') }}" method="POST" class="form-horizontal" id="form-listar_deudores">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
              <label for="id_institucion" class="col-sm-3 control-label">Institución</label>
              <div class="col-sm-9">
                <select class="selectpicker" name="id_institucion" id="id_institucion" title='Seleccione Institución'>
                  <option value="1">I.E. J. Soria</option>
                  <option value="2">CEBA Konrad Adenahuer</option>
                  <option value="3">I.S.T. Urusayhua</option>
                  <option value="4">Universidad Privada Líder Peruana</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="nombre_division" class="col-sm-3 control-label"></label>
              <div class="col-sm-9">
                <select class="selectpicker" name="id_detalle_institucion" id="id_detalle_institucion" title='Seleccione Nivel o Carrera'>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="grado" class="col-sm-3 control-label"></label>
              <div class="col-sm-9">
                <select class="selectpicker" name="grado" id="grado" title='Seleccione Grado o Semestre'>
                </select>
              </div>
            </div>
            <!-- EXCEL O PDF -->
            <div class="form-group">
              <label for="tipo_reporte" class="control-label col-sm-3">Tipo de Reporte</label>
              <div class="col-sm-9">
                <div class="radio">
                  <label>
                      <input type="radio" name="tipo_reporte" value="pdf" checked="checked">
                      <i class="input-helper"></i>PDF
                  </label>
                </div>
                <div class="radio">
                  <label>
                      <input type="radio" name="tipo_reporte" value="excel">
                      <i class="input-helper"></i>Excel
                  </label>
                </div>
              </div>
            </div>
            <!--/ EXCEL O PDF -->
            <div class="form-group">
              <div class="col-sm-3 col-sm-offset-9">
                <button type="submit" class="btn btn-warning waves-effect btn-block" id="btn-reporte-ListarIngreso" formtarget="_blank">Generar</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script src="{{ asset('js/reportes.js') }}"></script>
@endsection