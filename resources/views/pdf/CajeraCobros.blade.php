<!DOCTYPE html>
<html lang="es">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <title>Lista de Cobros del Dia</title>
  <link rel="stylesheet" href="{{ asset('css/reportes.css') }}">
</head>
<body>
  <div class="header">
    <h1>LISTA DE COBROS DEL DÍA</h1>
    <div class="text-right">Fecha: {{ $fecha }}</div>
  </div>
  <div class="footer">
    Página <span class="pagenum"></span>
  </div>
  <table class="bordered">
    <thead>
      <tr class="text-center">
        <td>Fecha</td>
        <td>Alumno (Cliente)</td>
        <td>Grado</td>
        <td>Categoría</td>
        <td>Comprobante</td>
        <td>Monto</td>
      </tr>
    </thead>
    <tbody>
      @foreach($ingresos as $ingreso)
        <tr>
          <td>{{ $ingreso->fecha }}</td>
          <td>{{ $ingreso->cliente }}</td>
          <td>{{ $ingreso->grado }}</td>
          <td>{{ $ingreso->categoria }}</td>
          <td>{{ $ingreso->comprobante }}</td>
          <td class="text-right">{{ number_format($ingreso->monto, 2) }}</td>
        </tr>
      @endforeach
    </tbody>
    <tfoot>
      <tr class="text-right">
        <td colspan="5"><strong>TOTAL (S/)</strong></td>
        <td>{{ $total }}</td>
      </tr>
    </tfoot>
  </table>
</body>
</html>