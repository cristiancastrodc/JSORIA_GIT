@extends('layouts.dashboard')

@section('title')
  Editar Usuario
@endsection

@section('content')
  @include('messages.errors')

  <div class="row">
    <div class="col-md-12">
      <div class="card hoverable">
        <div class="card-header main-color ch-alt">
          <h2>Editar Usuario</h2>
        </div>
        <div class="card-body card-padding">
          {!!Form::model($user, ['route' => ['admin.usuarios.update', $user->id], 'method' => 'PUT', 'class' => 'form-horizontal', 'id' => 'form-actualizar-usuario'])!!}
            <div class="form-group">
              {!! Form::label('dni', 'DNI', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-9">
                <div class="fg-line">
                  {!! Form::text('dni', null, ['class' => 'form-control input-sm', 'data-mask' => '00000000',]) !!}
                </div>
              </div>
            </div>
            <div class="form-group">
              {!! Form::label('nombres', 'Nombres', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-9">
                <div class="fg-line">
                  {!! Form::text('nombres', null, ['class' => 'form-control input-sm',]) !!}
                </div>
              </div>
            </div>
            <div class="form-group">
              {!! Form::label('apellidos', 'Apellidos', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-9">
                <div class="fg-line">
                  {!! Form::text('apellidos', null, ['class' => 'form-control input-sm',]) !!}
                </div>
              </div>
            </div>
            <div class="form-group">
              {!!Form::label('tipo', 'Tipo', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-9">
                <div class="fg-line">
                  {!! Form::text('tipo', null, ['class' => 'form-control input-sm', 'readonly' => 'readonly']) !!}
                </div>
              </div>
            </div>
            <div class="form-group">
              {!! Form::label('permisos[]', 'Permisos', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-9">
                <div class="fg-line">
                  <select name="permisos[]" id="permisos[]" multiple="" class="chosen" data-placeholder="Elegir Institucion(es)">
                    @foreach($todas_instituciones as $institucion)
                      <option value="{{ $institucion->id }}"
                        @if(in_array($institucion->id, $permisos)) selected="" @endif
                        @if(!in_array($institucion->id, $instituciones)) disabled="" @endif>{{ $institucion->nombre }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div class="form-group">
              {!!Form::label('usuario_login', 'Usuario',['class' => 'col-sm-3 control-label'])!!}
              <div class="col-sm-9">
                <div class="fg-line">
                  {!!Form::text('usuario_login',null,['class' => 'form-control input-sm',])!!}
                </div>
              </div>
            </div>
            <div class="form-group">
              {!!Form::label('password', 'Nueva Contraseña',['class' => 'col-sm-3 control-label'])!!}
              <div class="col-sm-9">
                <div class="fg-line">
                  {!!Form::password('password',['class' => 'form-control input-sm', 'placeholder' => 'Contraseña'])!!}
                </div>
                <small class="help-block">Si no desea cambiar la contraseña, deje este campo en blanco.</small>
              </div>
            </div>
            <input type="password" class="fake_pass" id="fake_pass" name="fake_pass">
            <div class="form-group">
              <div class="col-sm-3 col-sm-offset-6">
                <a href="{{ url('/admin/usuarios') }}" class="btn btn-link btn-block waves-effect"><i class="zmdi zmdi-close-circle-o"></i> Cancelar</a>
              </div>
              <div class="col-sm-3">
                <button type="button" class="btn btn-block accent-color waves-effect" id="btn-actualizar-usuario"><i class="zmdi zmdi-assignment-check"></i> Guardar</button>
              </div>
            </div>
          {!!Form::close()!!}
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script>
    $('#btn-actualizar-usuario').click(function(event) {
      $('option').removeAttr('disabled')
      $('#form-actualizar-usuario').submit()
    })
  </script>
@endsection
