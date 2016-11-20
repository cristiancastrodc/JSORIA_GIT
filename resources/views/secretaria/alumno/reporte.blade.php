<!DOCTYPE html>
<html lang="es">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <title>Reporte de Matrícula de Alumno</title>
  <link rel="stylesheet" href="{{ asset('css/reportes.css') }}">
</head>
<body>
  <div class="header">
    <h1>REPORTE DE MATRÍCULA DE ALUMNO</h1>
    <div class="text-right">Fecha: {{ $fecha }} </div>
    <div class="text-left">Alumno: {{ $alumno }}</div>
    <div class="text-left">Institución: {{ $matricula }}</div>
    <hr>
  </div>
  <div class="footer">
    Página <span class="pagenum"></span>
  </div>
  <br>
  <h2>CRONOGRAMA DE PAGOS</h2>
  <table class="bordered">
    <thead>
      <tr class="text-center">
        <td>Período</td>
        <td>Concepto</td>
        <td>Fecha Vencimiento</td>
        <td>Monto</td>
      </tr>
    </thead>
    <tbody>
      @foreach($categorias as $categoria)
      <tr>
        <td>{{ $categoria->periodo }}</td>
        <td>{{ $categoria->nombre }}</td>
        <td>
          @if($categoria->tipo == 'pension')
            {{ $categoria->fecha_fin }}
          @endif
        </td>
        <td class="text-right">{{ $categoria->monto }}</td>
      </tr>
      @endforeach
    </tbody>
    <tfoot>
      <tr class="text-right">
        <td colspan="3">Total Inversión:</td>
        <td>{{ $total }}</td>
      </tr>
    </tfoot>
  </table>
</body>
</html>