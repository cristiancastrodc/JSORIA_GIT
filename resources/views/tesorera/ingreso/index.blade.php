@extends('layouts.dashboard')

@section('title')
  Ingresos
@endsection

@section('content')
  <h1>INGRESOS</h1>

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
          {!!Form::open(['class' => 'form-horizontal'])!!}
            <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th class="hidden">Id</th>
                    <th class="warning c-white">Fecha - Hora</th>
                    <th class="warning c-white">Concepto</th>
                    <th class="warning c-white">Estado</th>
                    <th class="warning c-white">Monto</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="hidden">1</td>
                    <td>22/01/2016 12:04:01pm</td>
                    <td>Pensión Marzo Colegio</td>
                    <td><span class="bgm-orange c-white">No recogido</span></td>
                    <td>200.00</td>
                  </tr>
                </tbody>
                <tfoot class="text-right bgm-lightgreen c-white">
                  <tr>
                    <td colspan="3">Total no recogidos (S/)</td>
                    <td>200.00</td>
                  </tr>
                </tfoot>
              </table>
            </div>
            <div class="form-group">
              <button class="btn btn-warning waves-effect pull-right m-t-10">Recoger</button>
            </div>
          {!!Form::close()!!}
        </div>
      </div>
    </div>
  </div>
@endsection