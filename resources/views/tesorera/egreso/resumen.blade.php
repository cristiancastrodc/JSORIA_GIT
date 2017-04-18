@extends('layouts.dashboard')

@section('title')
  Resumen de @if($proceso == 'crear') Creación @else Edición @endif del Egreso
@endsection

@section('content')

  @if(Session::has('message'))
  <div class="row">
    <div class="col-sm-12">
      <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        {{ Session::get('message') }}
      </div>
    </div>
  </div>
  @endif

  @include('messages.errors')

  <div class="row">
    <div class="col-md-12">
      <div class="card hoverable">
        <div class="card-header main-color ch-alt">
          <h2>Resumen de @if($proceso == 'crear') Creación @else Edición @endif del Egreso</h2>
        </div>
        <div class="card-body card-padding">
          <div class="alert alert-success" role="alert">
            Egreso @if($proceso == 'crear') creado @else editado @endif correctamente.
          </div>
          <form class="form-horizontal">
            <div class="form-group">
              <label for="" class="col-sm-3 control-label">Tipo de Comprobante:</label>
              <div class="col-sm-9">
                <p class="form-control-static">{{ $egreso->tipo_comprobante }}</p>
              </div>
            </div>
            <div class="form-group">
              <label for="" class="col-sm-3 control-label">Número de Comprobante:</label>
              <div class="col-sm-9">
                <p class="form-control-static">{{ $egreso->numero_comprobante }}</p>
              </div>
            </div>
            <div class="form-group">
              <label for="" class="col-sm-3 control-label">Fecha Egreso:</label>
              <div class="col-sm-9">
                <p class="form-control-static">{{ $egreso->fecha_egreso }}</p>
              </div>
            </div>
            <div class="form-group">
              <label for="" class="col-sm-3 control-label">Institución:</label>
              <div class="col-sm-9">
                <p class="form-control-static">{{ $egreso->institucion }}</p>
              </div>
            </div>
            <div class="form-group">
              <label for="" class="col-sm-3 control-label">Fecha de Registro:</label>
              <div class="col-sm-9">
                <p class="form-control-static">{{ $egreso->fecha_registro }}</p>
              </div>
            </div>
            <div class="form-group">
              <label for="" class="col-sm-3 control-label">Razón Social:</label>
              <div class="col-sm-9">
                <p class="form-control-static">{{ $egreso->razon_social }}</p>
              </div>
            </div>
            <div class="form-group">
              <label for="" class="col-sm-3 control-label">Responsable:</label>
              <div class="col-sm-9">
                <p class="form-control-static">{{ $egreso->responsable }}</p>
              </div>
            </div>
          </form>
        </div>
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th class="accent-color c-white">Descripción</th>
                <th class="accent-color c-white">Rubro</th>
                <th class="accent-color c-white">Monto</th>
              </tr>
            </thead>
            <tbody>
              @foreach($detalle_egreso as $item)
                <tr>
                  <td>{{ $item->descripcion }}</td>
                  <td>{{ $item->rubro }}</td>
                  <td class="text-right">{{ number_format($item->monto, 2) }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <div class="card-body card-padding">
          <div class="row">
            <div class="col-sm-3">
              <a @if($proceso == 'crear') href="{{ url('/tesorera/egresos/create') }}" @else href="{{ url('/tesorera/egresos') }}" @endif class="btn btn-block main-color waves-effect"><i class="zmdi zmdi-long-arrow-left"></i> Volver</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
