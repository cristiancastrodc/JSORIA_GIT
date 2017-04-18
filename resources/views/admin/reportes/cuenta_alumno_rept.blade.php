<!DOCTYPE html>
<html lang="es">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <title>Cuenta de Alumno - {{ $alumno->nro_documento }}</title>
  <link rel="stylesheet" href="{{ url('css/reporte/150') }}">
</head>
<body>
  <div class="header">
    <table>
      <tr>
        <td colspan="6" class="text-center"><h1>REPORTE DE CUENTA DE ALUMNO</h1></td>
      </tr>
      <tr>
        <td colspan="6"><div class="text-right">Fecha: {{ $fecha }}</div></td>
      </tr>
      <tr>
        <td>Alumno:</td>
        <td colspan="5">{{ $alumno->nombres }} {{ $alumno->apellidos }}</td>
      </tr>
      <tr>
        <td>Periodo:</td>
        <td colspan="5">{{ $periodo }}</td>
      </tr>
    </table>
    <hr>
  </div>
  <div class="footer">
    Página <span class="pagenum"></span>
  </div>
  <table class="bordered">
    <thead>
      <tr class="text-center">
        <td>Concepto</td>
        <td>Fecha Vcto.</td>
        <td>Estado</td>
        <td>Fecha Pago</td>
        <td>Comprobante</td>
        <td>Monto</td>
      </tr>
    </thead>
    <tbody>
      @foreach($cuenta as $item)
        <tr>
          <td>{{ $item->nombre }}</td>
          <td>
            @if($item->tipo == 'pension')
            {{ $item->fecha_fin }}
            @endif
          </td>
          <td>
            @if($item->estado_pago == 1)
            Cancelado
            @else
            Pendiente
            @endif
          </td>
          <td>{{ $item->fecha_hora_ingreso }}</td>
          <td>
            @if($item->estado_pago == 1)
              {{ $item->tipo_comprobante }} {{ $item->serie_comprobante }}-{{ $item->numero_comprobante }}
            @endif
          </td>
          <td class="text-right">
            {{ number_format($item->saldo - $item->descuento, 2) }}
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</body>
</html>