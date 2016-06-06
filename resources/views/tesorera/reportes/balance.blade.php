<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <title>Balance de Ingresos y Egresos</title>
  <link rel="stylesheet" href="{{ asset('css/reportes.css') }}">
</head>
<body>
  <header>
    <h1>BALANCE DE INGRESOS Y EGRESOS</h1>
    <div class="date">Fecha: {{ $fecha }}</div>
    <hr>
  </header>
  <main>
    <h2>RESUMEN</h2>
    <table class="bordered">
      <thead>
        <tr class="text-center"><td>Saldo anterior ({{ $balance->fecha }})</td><td>Ingresos</td><td>Egresos</td><td>Saldo Actual</td></tr>
      </thead>
      <tbody>
        <tr class="text-right"><td>{{ $balance->saldo_anterior }}</td><td>{{ $balance->ingresos }}</td><td>{{ $balance->egresos }}</td><td>{{ $balance->saldo_actual }}</td></tr>
      </tbody>
    </table>
    <h2>DETALLADO</h2>
    <table class="bordered">
      <thead>
        <tr class="text-center">
          <td>Tipo Doc.</td>
          <td>Nro. Doc.</td>
          <td>Descripción</td>
          <td>Ingreso</td>
          <td>Egreso</td>
        </tr>
      </thead>
      <tbody>
        @foreach($balance_detallado as $item)
          <tr class="{{ $item->class }}">
            <td>{{ $item->denominacion }}</td>
            <td>{{ $item->numero_comprobante }}</td>
            <td>{{ $item->descripcion }}</td>
            <td class="text-right">{{ number_format($item->ingreso, 2) }}</td>
            <td class="text-right">{{ number_format($item->egreso, 2) }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </main>
</body>
</html>