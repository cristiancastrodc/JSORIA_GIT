@extends('layouts.dashboard')

@section('title')
  Cerrar Ciclo
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
          <h2>Cerrar Ciclo</h2>
        </div>
        <div class="card-body card-padding">
          {!!Form::open(array('route' => 'secretaria.ciclo.cerrar.store', 'class' => 'form-horizontal', 'method' => 'POST'))!!}
            <div class="form-group">
              <label for="id_institucion" class="col-sm-3 control-label">Institución</label>
              <div class="col-sm-9">
                <select class="selectpicker" name="id_institucion" id="id_institucion" title='Elegir Institucion'>
                  @foreach($permisos as $permiso)
                    <option value="{{ $permiso->id }}">{{$permiso->nombre}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-3 col-sm-offset-9">
                <button class="btn btn-block accent-color waves-effect m-t-10" >Cerrar Ciclo</button>
              </div>
            </div>
          {!!Form::close()!!}

        </div>
      </div>
    </div>
  </div>
@endsection