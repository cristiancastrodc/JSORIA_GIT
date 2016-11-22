@extends('layouts.dashboard')

@section('title')
  Retiros
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
    <div class="col-md-10">
      <div class="card  hoverable">
        <div class="card-header main-color ch-alt">
          <h2>Retiros</h2>
        </div>
        <div class="card-body card-padding">
          {!!Form::open(['class' => 'form-horizontal', 'id' => 'form-retiros'])!!}
          <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
          <div class="table-responsive">
            <table class="table table-bordered" id="retiros">
              <thead>
                <tr>
                  <th class="accent-color c-white" type="hidden" >id</th>
                  <th class="accent-color c-white">Fecha - Hora</th>
                  <th class="accent-color c-white">Tesorera</th>
                  <th class="accent-color c-white">Monto (S/)</th>
                </tr>
              </thead>
              <tbody>
                @foreach($retiro as $ingreso)
                  <tr>
                    <td type="hidden">{{$ingreso->id}}</td>
                    <td>{{$ingreso->fecha_hora_creacion}}</td>
                    <td>{{$ingreso->nombres . '  '.$ingreso->apellidos}}</td>
                    <td>{{$ingreso->monto}}</td>
                    <td>
                      <a href='#modal-confirmar-autorizacion' data-toggle='modal' class='btn third-color' data-id="{{ $ingreso->id }}"><i class='zmdi zmdi-edit'> Confirmar</i></a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          {!!Form::close()!!}
        </div>
      </div>
    </div>
  </div>
@endsection

@section('modals')
  @include('layouts.modals.confirmar')
@endsection
@section('scripts')
  <script src="{{ asset('js/cajera.js') }}"></script>
@endsection