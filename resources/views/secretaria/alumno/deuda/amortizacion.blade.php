@extends('layouts.dashboard')

@section('title')
  Autorizar Amortización
@endsection

@section('content')
  <h1>AUTORIZAR AMORTIZACIÓN</h1>

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
            <div class="form-group">
              <label for="dni" class="col-sm-3 control-label">DNI</label>
              <div class="col-sm-9">
                  <div class="fg-line">
                      <input type="text" class="form-control input-sm" id="dni" name="dni" placeholder="DNI">
                  </div>
              </div>
            </div>
            <div class="form-group">
              <div class="pull-right">
                <button class="btn btn-warning waves-effect">Buscar</button>
              </div>
            </div>
          {!!Form::close()!!}
        </div>
      </div>
      <div class="card">
        <div class="card-body card-padding">
          <div class="table-responsive">
              <table class="table table-bordered">
                  <thead>
                      <tr>
                          <th class="warning c-white">Concepto</th>
                          <th class="warning c-white">Monto (S/)</th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr>
                          <td>Pensión Marzo 2016</td>
                          <td>500.00</td>
                          <td>
                            <button class="btn bgm-lightgreen waves-effect">Amortizar</button>
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