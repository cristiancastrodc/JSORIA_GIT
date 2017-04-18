<!DOCTYPE html>
<html lang="es">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <title>Deudas de Alumno - {{ $alumno->nro_documento }}</title>
  <link rel="stylesheet" href="{{ asset('css/reportes.css') }}">
</head>
<body>
  <div class="header header-90">
    <table>
      <tr>
        <td colspan="3" class="text-center"><h1>REPORTE DE DEUDAS DE ALUMNO</h1></td>
      </tr>
      <tr>
        <td colspan="3"><div class="text-right">Fecha: {{ $fecha }}</div></td>
      </tr>
      <tr>
        <td>Alumno:</td>
        <td colspan="2">{{ $alumno->nombres }} {{ $alumno->apellidos }}</td>
      </tr>
    </table>
    <hr>
  </div>
  <div class="footer">
    Página <span class="pagenum"></span>
  </div>
  <div class="space-50"></div>
  <table class="bordered">
    <thead>
      <tr class="text-center">
        <td>Concepto</td>
        <td>Fecha Vcto.</td>
        <td>Periodo</td>
        <td>Monto</td>
      </tr>
    </thead>
    <tbody>
      @foreach($deudas as $deuda)
        <tr>
          <td>{{ $deuda->nombre }}</td>
          <td>
            @if($deuda->tipo == 'pension')
            {{ $deuda->fecha_fin }}
            @endif
          </td>
          <td class="text-right">
            {{ $deuda->periodo }}
          </td
          <td class="text-right">
            {{ number_format($deuda->saldo - $deuda->descuento, 2) }}
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</body>
</html>