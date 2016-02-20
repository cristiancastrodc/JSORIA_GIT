@extends('layouts.dashboard')

@section('title')
  Retiros
@endsection

@section('content')
  <h1>RETIROS</h1>

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
          <div class="table-responsive">
              <table class="table table-bordered">
                  <thead>
                      <tr>
                          <th class="warning c-white">Fecha - Hora</th>
                          <th class="warning c-white">Usuario</th>
                          <th class="warning c-white">Monto (S/)</th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr>
                          <td>20-01-2016 10:13</td>
                          <td>Tesorera1</td>
                          <td>500.00</td>
                          <td>
                            <button class="btn btn-floating-action color-block bgm-bluegray waves-effect" data-toggle="modal" data-target="#ModalDetalle">Ver detalle</button>
                            <button class="btn btn-floating-action color-block bgm-lightgreen waves-effect" data-toggle="modal" data-target="#ModalConfirmacion">Confirmar</button>
                          </td>
                      </tr>
                  </tbody>
              </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection