@extends('layouts.dashboard')
@section('title')
  Editar Usuario
@endsection

@section('content')
  @include('messages.errors')

  <div class="row">
    <div class="col-md-10">
      <div class="card hoverable">
        <div class="card-header main-color ch-alt">
          <h2>Editar Usuario</h2>
        </div>
        <div class="card-body card-padding">
          {!!Form::model($user, ['route' => ['admin.usuarios.update',$user->id], 'method' => 'PUT', 'class' => 'form-horizontal'])!!}
            <div class="form-group">
              {!!Form::label('dni', 'DNI',['class' => 'col-sm-3 control-label'])!!}
              <div class="col-sm-9">
                <div class="fg-line">
                  {!!Form::text('dni',null,['class' => 'form-control input-sm', 'data-mask' => '00000000',])!!}
                </div>
              </div>
            </div>
            <div class="form-group">
              {!!Form::label('nombres', 'Nombres',['class' => 'col-sm-3 control-label'])!!}
              <div class="col-sm-9">
                <div class="fg-line">
                  {!!Form::text('nombres',null,['class' => 'form-control input-sm',])!!}
                </div>
              </div>
            </div>
            <div class="form-group">
              {!!Form::label('apellidos', 'Apellidos',['class' => 'col-sm-3 control-label'])!!}
              <div class="col-sm-9">
                <div class="fg-line">
                  {!!Form::text('apellidos',null,['class' => 'form-control input-sm',])!!}
                </div>
              </div>
            </div>
            <div class="form-group">
              {!!Form::label('tipo', 'Tipo',['class' => 'col-sm-3 control-label'])!!}
              <div class="col-sm-9">
                <div class="fg-line">
                  {!!Form::text('tipo',null,['class' => 'form-control input-sm', 'readonly' => 'readonly'])!!}
                </div>
              </div>
            </div>
            <div class="form-group">
              {!!Form::label('permisos[]', 'Nuevos Permisos',['class' => 'col-sm-3 control-label'])!!}
              <div class="col-sm-9">
                <div class="fg-line">
                  {!!Form::select('permisos[]', array('1' => 'I.E. J. Soria', '2' => 'CEBA Konrad Adenahuer', '3' => 'I.S.T. Urusayhua'), null, ['class' => 'chosen', 'multiple' => 'multiple', 'data-placeholder' => 'Elegir Institucion(es)'])!!}
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
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-3 col-sm-offset-9">
                <button class="btn btn-block accent-color waves-effect m-t-10">Guardar</button>
              </div>
            </div>
          {!!Form::close()!!}
        </div>
      </div>
    </div>
  </div>
@endsection