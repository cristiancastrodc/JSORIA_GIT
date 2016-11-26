<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <title>Reporte de Ingresos Totales</title>
  <link rel="stylesheet" href="{{ asset('css/reportes200.css') }}">
</head>
<body>
  <div class="header">
    <table>
      <tr>
        <td colspan="4" class="text-center"><h1>INGRESOS AGRUPADOS POR {{ $tipo_periodo }}</h1></td>
      </tr>
      <tr>
        <td>Institución:</td>
        <td colspan="3">{{ $institucion->nombre }}</td>
      </tr>
      <tr>
        <td>Fecha Inicial:</td>
        <td colspan="3">{{ $fecha_inicio }}</td>
      </tr>
      <tr>
        <td>Fecha Final:</td>
        <td colspan="3">{{ $fecha_fin }}</td>
      </tr>
    </table>
    <hr>
  </div>
  <div class="footer">
    Página <span class="pagenum"></span>
  </div>
  <table class="bordered">
    <thead>
      <tr>
        <td></td>
        <td>Período</td>
        <td>Monto</td>
        <td></td>
      </tr>
    </thead>
    <tbody>
      @foreach($datas as $data)
      <tr>
        <td></td>
        <td> {{ $data['fecha1'] }} {{ $data['fecha2'] }}</td>
        <td class="text-right"> {{ number_format($data['monto'], 2) }}</td>
        <td></td>
      </tr>
      @endforeach
    </tbody>
  </table>
</body>
</html>