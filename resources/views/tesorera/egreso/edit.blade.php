@extends('layouts.dashboard')

@section('title', 'Modificar Egreso')

@section('content')

  @if(Session::has('message'))
    <div class="row">
      <div class="col-sm-12">
        <div class="alert alert-success alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          {{ Session::get('message') }}
        </div>
      </div>
    </div>
  @endif

  @include('messages.errors')

  <div class="row">
    <div class="col-md-12">
      <div class="card hoverable">
        <div class="card-header main-color ch-alt">
          <h2>Modificar Egreso</h2>
        </div>
        <div class="card-body card-padding">
          <form class="form-horizontal" id="form-modificar-egreso-tesorera">
            <input type="hidden" name="_token" value="{{csrf_token()}}" id="_token">
            <input type="hidden" name="id_egreso" value="{{ $egreso->id }}" id="id_egreso">
            <div class="form-group">
              <label for="id_institucion" class="col-sm-3 control-label">Institución</label>
              <div class="col-sm-9">
                <select class="selectpicker" name="id_institucion" id="id_institucion">
                  @foreach($permisos as $permiso)
                    @if ($permiso->id == $egreso->id_institucion)
                      <option value="{{ $permiso->id }}" selected="">{{ $permiso->nombre }}</option>
                    @else
                      <option value="{{ $permiso->id }}">{{ $permiso->nombre }}</option>
                    @endif
                  @endforeach
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="tipo_comprobante" class="col-sm-3 control-label">Tipo de comprobante</label>
              <div class="col-sm-9">
                <p class="form-control-static">{{ $comprobante }}</p>
              </div>
            </div>
            <div class="form-group">
              <label for="numero_comprobante" class="col-sm-3 control-label">Número</label>
              <div class="col-sm-9">
                <div class="fg-line">
                  <input type="text" class="form-control input-sm" id="numero_comprobante" name="numero_comprobante" placeholder="Número" autocomplete="off" value="{{ $egreso->numero_comprobante }}">
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="fecha" class="col-sm-3 control-label">Fecha</label>
              <div class="col-sm-9">
                <div class="fg-line">
                  <div class="dtp-container fg-line">
                    <input type='text' class="form-control date-picker" placeholder="Elija la fecha" name="fecha_egreso" id="fecha_egreso" value="{{ $egreso->fecha }}">
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="razon_social" class="col-sm-3 control-label">Razon Social</label>
              <div class="col-sm-9">
                <div class="fg-line">
                  <input type="text" class="form-control input-sm" id="razon_social" name="razon_social" placeholder="Razon Social" autocomplete="off" value="{{ $egreso->razon_social }}">
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="responsable" class="col-sm-3 control-label">Responsable</label>
              <div class="col-sm-9">
                <div class="fg-line">
                  <input type="text" class="form-control input-sm" id="responsable" name="responsable" placeholder="Responsable" autocomplete="off" value="{{ $egreso->responsable }}">
                </div>
              </div>
            </div>
            <div class="form-group">
            <div class="table-responsive">
              <table class="table" id="tabla-resumen-egresos">
                <thead>
                  <tr>
                    <th class="accent-color c-white">Descripcion</th>
                    <th class="accent-color c-white">Rubro</th>
                    <th class="accent-color c-white">Monto (S/)</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($detalles_egreso as $detalle)
                    <tr>
                      <td class="hidden detalle-egreso-id">{{ $detalle->nro_detalle_egreso }}</td>
                      <td>
                        <div class="fg-line">
                          <input type="text" class="form-control egreso-descripcion" value="{{ $detalle->descripcion }}">
                        </div>
                      </td>
                      <td>
                        <div class="fg-line">
                          <select name="egreso-rubro-id" class="selectpicker egreso-rubro-id" data-container="body">
                            <option value="{{ $detalle->id_rubro }}">{{ $detalle->nombre }}</option>
                            @foreach($rubros as $rubro)
                            <option value="{{ $rubro->id }}">{{ $rubro->nombre }}</option>
                            @endforeach
                          </select>
                        </div>
                      </td>
                      <td>
                        <div class="fg-line">
                          <input type="number" class="form-control egreso-monto text-right" value="{{ $detalle->monto }}">
                        </div>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-sm-offset-9 col-sm-3">
                  <button class="btn accent-color waves-effect btn-block" id="btn-modificar-egreso"><i class="zmdi zmdi-assignment-check"></i> Guardar</button>
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
  <script src="{{ asset('js/tesorera.js') }}"></script>
@endsection
