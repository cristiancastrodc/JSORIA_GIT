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
          {!!Form::open(['class' => 'form-horizontal', 'id' => 'form-retiros'])!!}
          <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
          <div class="table-responsive">
            <table class="table table-bordered" id="retiros">
              <thead>
                <tr>
                <th class="warning c-white" type="hidden" >id</th>
                  <th class="warning c-white">Fecha - Hora</th>
                  <th class="warning c-white">Tesorera</th>
                  <th class="warning c-white">Monto (S/)</th>
                </tr>
              </thead>
              <tbody>
                @foreach($retiro as $ingreso)
                  <tr>
                    <td type="hidden">{{$ingreso->id}}</td>
                    <td>{{$ingreso->fecha_hora}}</td>
                    <td>{{$ingreso->nombres . '  '.$ingreso->apellidos}}</td>
                    <td>{{$ingreso->monto}}</td>
                    <td>
                      <a href='#modal-confirmar-autorizacion' data-toggle='modal' class='btn bgm-amber' data-id="{{ $ingreso->id }}"><i class='zmdi zmdi-edit'> Confirmar</i></a>
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