@extends('layouts.dashboard')

@section('title')
  Reporte de Cobros
@endsection

@section('content')
  <h1>REPORTE DE COBROS</h1>

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
         {!!Form::open(array('class' => 'form-horizontal', 'id' => 'form-otros-reportes','route' => 'cajera.reporte.generar','method' => 'POST'))!!}
            <div class="form-group">
              <label for="fecha" class="col-sm-3 control-label">Fecha:</label>
                <div class="col-sm-9">
                    <div class="fg-line">
                        <div class="dtp-container fg-line">
                            <input type='text' class="form-control date-picker" placeholder="Fecha" name="fecha" id="fecha" autocomplete="off">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
              <div class="pull-right">
                <button type="submit" class="btn btn-warning waves-effect" id="btn-reporte-EgresosRubro" formtarget="_blank">Generar</button>
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