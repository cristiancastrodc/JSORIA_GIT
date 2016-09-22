@extends('layouts.dashboard')

@section('title')
  Administrar Usuarios
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
    <div class="col-md-5">
      <div class="card hoverable">
        <div class="card-header main-color ch-alt">
          <h2>Nuevo Usuario</h2>
        </div>
        <div class="card-body card-padding">
          {!!Form::open(array('route' => 'admin.usuarios.store', 'class' => 'form-horizontal', 'method' => 'POST'))!!}
            <div class="form-group">
              <label for="dni" class="col-sm-3 control-label">DNI</label>
              <div class="col-sm-9">
                <div class="fg-line">
                  <input type="text" class="form-control input-sm" id="dni" name="dni" placeholder="DNI" data-mask="00000000">
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="nombres" class="col-sm-3 control-label">Nombres</label>
              <div class="col-sm-9">
                <div class="fg-line">
                  <input type="text" class="form-control input-sm" id="nombres" name="nombres" placeholder="Nombres">
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="apellidos" class="col-sm-3 control-label">Apellidos</label>
              <div class="col-sm-9">
                <div class="fg-line">
                  <input type="text" class="form-control input-sm" id="apellidos" name="apellidos" placeholder="Apellidos">
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="tipo" class="col-sm-3 control-label">Tipo</label>
              <div class="col-sm-9">
                <select class="selectpicker" name="tipo" id="tipo">
                  <option>Administrador</option>
                  <option>Cajera</option>
                  <option>Secretaria</option>
                  <option>Tesorera</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="permisos" class="col-sm-3 control-label">Permisos</label>
              <div class="col-sm-9">
                <div class="fg-line">
                  <div class="select">
                    <select class="chosen" multiple data-placeholder="Elegir..." id="permisos" name="permisos[]">
                      <option value="1">I.E. J. Soria</option>
                      <option value="2">CEBA Konrad Adenahuer</option>
                      <option value="3">I.S.T. Urusayhua</option>
                      <option value="4">ULP</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="user" class="col-sm-3 control-label">Usuario</label>
              <div class="col-sm-9">
                <div class="fg-line">
                  <input type="text" class="form-control input-sm" id="usuario_login" name="usuario_login" placeholder="Usuario">
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="password" class="col-sm-3 control-label">Contraseña</label>
              <div class="col-sm-9">
                <div class="fg-line">
                  <input type="password" class="form-control input-sm" id="password" name="password" placeholder="Contraseña">
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-6 col-sm-offset-6">
                <button class="btn btn-block accent-color waves-effect m-t-10">Guardar</button>
              </div>
            </div>
          {!!Form::close()!!}
        </div>
      </div>
    </div>
    <div class="col-md-7">
      <div class="card hoverable">
        <div class="card-header main-color ch-alt">
          <h2>Lista de Usuarios</h2>
        </div>
        <div class="card-body card-padding">
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th class="accent-color c-white">Nombres</th>
                  <th class="accent-color c-white">Apellidos</th>
                  <th class="accent-color c-white">Tipo</th>
                  <th class="accent-color c-white">Acciones</th>
                </tr>
              </thead>
              <tbody>
                @foreach($users as $user)
                  <tr>
                    <td>{{$user->nombres}}</td>
                    <td>{{$user->apellidos}}</td>
                    <td>{{$user->tipo}}</td>
                    <td>
                      {!!link_to_route('admin.usuarios.edit', $title = 'Editar', $parameters = $user->id, $attributes = ['class' => 'btn btn-info waves-effect', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'data-original-title' => 'Modificar'])!!}
                      {!!Form::open(['route' => ['admin.usuarios.destroy', $user->id], 'method' => 'DELETE', 'class' => 'inline-form'])!!}
                        <button type="submit" class="btn btn-danger waves-effect" data-toggle="tooltip" data-placement="top" data-original-title="Eliminar"><i class="zmdi zmdi-delete"></i></button>
                      {!!Form::close()!!}
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection