@extends('layouts.dashboard')

@section('title')
  Actualizar Perfil
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
      <div class="card hoverable">
        <div class="card-header main-color ch-alt">
          <h2>Actualizar Perfil de Usuario</h2>
        </div>
        <div class="card-body card-padding">
          <form class="form-horizontal">
            <input type="hidden" id="_token" value="{{ csrf_token() }}">
            <div class="form-group">
              <label for="nombre" class="col-sm-3 control-label">Nombre:</label>
              <div class="col-sm-9">
                <div class="fg-line">
                    <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $usuario->nombres }} {{ $usuario->apellidos}}" disabled>
                </div>
              </div>
            </div>
            <div class="form-group">
                <label for="usuario" class="col-sm-3 control-label">Usuario:</label>
                <div class="col-sm-9">
                    <div class="fg-line">
                        <input type="text" class="form-control input-sm" id="usuario" name="usuario" value="{{ $usuario->usuario_login }}" disabled>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="new_password" class="control-label col-sm-3">Nueva contraseña:</label>
                <div class="col-sm-9">
                    <div class="fg-line">
                      <input type="password" class="form-control" id="new_password" placeholder="Nueva contraseña" autocomplete="off">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="old_password" class="control-label col-sm-3">Contraseña anterior:</label>
                <div class="col-sm-9">
                    <div class="fg-line">
                      <input type="password" class="form-control" id="old_password" placeholder="Contraseña anterior" autocomplete="off">
                    </div>
                </div>
            </div>
            <div class="form-group">
              <div class="row p-r-15">
                <div class="col-sm-3 col-sm-offset-9">
                  <button class="btn bgm-blue-soria btn-block m-t-10" id="btn-guardar-contraseña"> Guardar</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script src="{{ asset('js/general.js') }}"></script>
@endsection