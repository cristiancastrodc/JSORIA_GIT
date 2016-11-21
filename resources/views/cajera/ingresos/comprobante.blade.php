@extends('layouts.dashboard')

@section('title')
  Comprobante de Pago
@endsection

@section('styles')
  <style>
    @media print {
      body {
        font-size: 10px;
      }
      .p-col-sm-6 {
        width: 49.5%;
        display: inline-block;
      }
      #main {
        padding-top: 3.25cm;
        padding-bottom: 0;
      }
      .card {
        margin-bottom: 0;
      }
      h3 {
        font-size: 12px;
        margin-top: 5px;
        margin-bottom: 5px;
      }
      .linea-firma {
        margin-top: 1cm;
      }
    }
  </style>
@endsection

@section('content')

  @if(Session::has('message'))
    <div class="row">
      <div class="col-sm-10">
        <div class="alert alert-success alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          {{Session::get('message')}}
        </div>
      </div>
    </div>
  @endif

  @include('messages.errors')

  <div class="row">
    <div class="col-md-10">
      <div class="card hoverable">
        <div class="card-header main-color ch-alt">
          <h2 class="hidden-print">Comprobante de Pago</h2>
        </div>
        <div class="card-body card-padding">
          <div class="row">
            <div class="col-sm-6 p-col-sm-6">
              <table class="table">
                <tr>
                  <td class="p-0">Fecha Hora:</td>
                  <td class="p-0">{{ $fecha_hora }}</td>
                </tr>
                <tr>
                  <td class="p-0">Nro. Documento:</td>
                  <td class="p-0">{{ $nro_documento }}</td>
                </tr>
                <tr>
                  <td class="p-0">Alumno:</td>
                  <td class="p-0">{{ $alumno->nombres }} {{ $alumno->apellidos }}</td>
                </tr>
                @if($tipo_comprobante == 'factura')
                  <tr>
                    <td class="p-0">RUC:</td>
                    <td class="p-0">{{ $comprobante->ruc }}</td>
                  </tr>
                  <tr>
                    <td class="p-0">Razón Social:</td>
                    <td class="p-0">{{ $comprobante->razon_social }}</td>
                  </tr>
                  <tr>
                    <td class="p-0">Dirección:</td>
                    <td class="p-0">{{ $comprobante->direccion }}</td>
                  </tr>
                @endif
              </table>
              <h3>Detalle</h3>
              <table class="table">
                <thead>
                  <tr>
                    <th class="p-0">Concepto</th>
                    <th class="p-0">Monto</th>
                  </tr>
                </thead>
                <tbody>
                @foreach($pagos as $pago)
                  <tr>
                    <td class="p-0">{{ $pago->nombre }}</td>
                    <td class="p-0 text-right">{{ number_format($pago->monto_pagado, 2) }}</td>
                  </tr>
                @endforeach
                @foreach($conceptos as $concepto)
                  <tr>
                    <td class="p-0">{{ $concepto->nombre }} x {{ $concepto->cantidad }}</td>
                    <td class="p-0 text-right">{{ number_format($concepto->total, 2) }}</td>
                  </tr>
                @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <td class="p-0 text-right"><b>Total (S/)</b></td>
                    <td class="p-0 text-right">{{ $total }}</td>
                  </tr>
                </tfoot>
              </table>
              <p>Son: {{ $letras }}</p>
              <div class="linea-firma text-right">__________________________________</div>
            </div>
            <div class="col-sm-6 p-col-sm-6">
              <table class="table">
                <tr>
                  <td class="p-0">Fecha Hora:</td>
                  <td class="p-0">{{ $fecha_hora }}</td>
                </tr>
                <tr>
                  <td class="p-0">Nro. Documento:</td>
                  <td class="p-0">{{ $nro_documento }}</td>
                </tr>
                <tr>
                  <td class="p-0">Alumno:</td>
                  <td class="p-0">{{ $alumno->nombres }} {{ $alumno->apellidos }}</td>
                </tr>
                @if($tipo_comprobante == 'factura')
                  <tr>
                    <td class="p-0">RUC:</td>
                    <td class="p-0">{{ $comprobante->ruc }}</td>
                  </tr>
                  <tr>
                    <td class="p-0">Razón Social:</td>
                    <td class="p-0">{{ $comprobante->razon_social }}</td>
                  </tr>
                  <tr>
                    <td class="p-0">Dirección:</td>
                    <td class="p-0">{{ $comprobante->direccion }}</td>
                  </tr>
                @endif
              </table>
              <h3>Detalle</h3>
              <table class="table">
                <thead>
                  <tr>
                    <th class="p-0">Concepto</th>
                    <th class="p-0">Monto</th>
                  </tr>
                </thead>
                <tbody>
                @foreach($pagos as $pago)
                  <tr>
                    <td class="p-0">{{ $pago->nombre }}</td>
                    <td class="p-0 text-right">{{ number_format($pago->monto_pagado, 2) }}</td>
                  </tr>
                @endforeach
                @foreach($conceptos as $concepto)
                  <tr>
                    <td class="p-0">{{ $concepto->nombre }} x {{ $concepto->cantidad }}</td>
                    <td class="p-0 text-right">{{ number_format($concepto->total, 2) }}</td>
                  </tr>
                @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <td class="p-0 text-right"><b>Total (S/)</b></td>
                    <td class="p-0 text-right">{{ $total }}</td>
                  </tr>
                </tfoot>
              </table>
              <p>Son: {{ $letras }}</p>
              <div class="linea-firma text-right">__________________________________</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script>
    window.print()
  </script>
@endsection