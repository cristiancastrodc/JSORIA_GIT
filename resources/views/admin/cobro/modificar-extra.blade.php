@extends('layouts.dashboard')

@section('title')
  Administrar Cobros Extraordinarios
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
          <h2>Listar Cobros Extraordinarios</h2>
        </div>
        <div class="card-body card-padding">
          {!!Form::open(array('class' => 'form-horizontal', 'id' => 'form-listar-c-otros'))!!}
            <div class="form-group">
              <label for="id_institucion" class="col-sm-3 control-label">Institución</label>
              <div class="col-sm-9">
                <select class="selectpicker" name="id_institucion" id="id_institucion" title='Elegir Institución'>
                  <option value="1">I.E. J. Soria</option>
                  <option value="2">CEBA Konrad Adenahuer</option>
                  <option value="3">I.S.T. Urusayhua</option>
                  <option value="4">Universidad Privada Líder Peruana</option>                  
                </select>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-4 col-sm-offset-8">
                <button class="btn btn-block accent-color waves-effect m-t-10" id="btn-listar-c-otros">Buscar</button>
              </div>
            </div>
          {!!Form::close()!!}
        </div>
      </div>
      <div class="card hoverable">
        <div class="card-body card-padding">
          <div class="table-responsive">
            <table id="tabla-listar-c-otros" class="table table-striped">
                <thead>
                    <tr>
                        <th class="hidden">Id</th>
                        <th class="accent-color c-white">Concepto</th>
                        <th class="accent-color c-white">Monto</th>
                        <th class="accent-color c-white">Estado</th>
                        <th class="accent-color c-white">Anular</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('modals')
  @include('layouts.modals.c-otro')
@endsection

@section('scripts')
  <script src="{{ asset('js/admin.js') }}"></script>
@endsection
