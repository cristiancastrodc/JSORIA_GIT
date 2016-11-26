<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Reporte Alumnos Deudores</title>
    <link rel="stylesheet" href="{{ asset('css/reportes150.css') }}">
</head>
<body>
  <div class="header">
    <table>
      <tr><td colspan="5" class="text-center"><h1>LISTA DE ALUMNOS DEUDORES</h1></td></tr>
      <tr><td>Institución:</td>
      <td colspan="4">{{ $institucion->nombre }} @if($nombre_nivel != 'Todo') - {{ $nombre_nivel }} @endif</td></tr>
      @if($nombre_nivel != 'Todo')
      <tr><td>Grado:</td>
      <td colspan="4">{{ $grado->nombre_grado }}</td></tr>
      @endif
    </table>
    <hr>
  </div>
  <div class="footer">
    Página <span class="pagenum"></span>
  </div>
  <table class="bordered">
    <thead>
      <tr>
        <td>Nro. Documento</td>
        <td>Alumno</td>
        <td>Concepto</td>
        <td>Fecha Vencimiento</td>
        <td>Monto</td>
      </tr>
    </thead>
    <tbody>
      @foreach($deudas as $deuda)
      <tr>
        <td>{{ $deuda->nro_documento }}</td>
        <td>{{ $deuda->nombres }} {{ $deuda->apellidos }}</td>
        <td>{{ $deuda->nombre }}</td>
        <td>{{ $deuda->fecha_fin }}</td>
        <td>{{ number_format($deuda->saldo - $deuda->descuento , 2) }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</body>
</html>