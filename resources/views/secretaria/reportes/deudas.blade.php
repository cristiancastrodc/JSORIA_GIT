@extends('layouts.dashboard')

@section('title')
  Reporte de Deudas por Grado
@endsection

@section('content')
  @if(Session::has('message'))
  <div class="row">
    <div class="col-sm-10">
      <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        {{Session::get('message')}}
      </div>
    </div>
  </div>
  @endif

  @include('messages.errors')

  <div class="row">
    <div class="col-md-10">
      <div class="card hoverable">
        <div class="card-header main-color ch-alt">
          <h2>Deudas por Grados</h2>
        </div>
        <div class="card-body card-padding">
          <form action="{{ url('/secretaria/procesar/reporte/deudas_por_grado') }}" class="form-horizontal">
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
              <label for="grado" class="col-sm-3 control-label">Grado</label>
              <div class="col-sm-9">
                <select class="selectpicker" name="grado" id="grado" title='Seleccione'>
                </select>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-3 col-sm-offset-9">
                <button type="submit" class="btn btn-block waves-effect m-t-15 accent-color" formtarget="_blank">Procesar</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
