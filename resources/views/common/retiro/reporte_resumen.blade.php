<!DOCTYPE html>
<html lang="es">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <title>Resumen de Creación de Retiro</title>
  <link rel="stylesheet" href="{{ url('css/reporte/100') }}">
</head>
<body>
  <div class="header">
    <table>
      <tr>
        <td colspan="6" class="text-center"><h1>RESUMEN DE CREACIÓN DE RETIRO</h1></td>
      </tr>
      <tr>
        <td colspan="6"><div class="text-right">Fecha: {{ $fecha }}</div></td>
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
        <td>Fecha Ingreso</td>
        <td>Concepto</td>
        <td>Documento</td>
        <td>Monto</td>
      </tr>
    </thead>
    <tbody>
      @foreach($cobros as $cobro)
        <tr>
          <td>{{ $cobro->fecha_hora_ingreso }}</td>
          <td>{{ $cobro->nombre }}</td>
          <td>{{ $cobro->documento }}</td>
          <td class="text-right">
            {{ number_format($cobro->monto, 2) }}
          </td>
        </tr>
      @endforeach
    </tbody>
    <tfoot>
      <tr class="text-right strong">
        <td colspan="3"><strong>TOTAL:</strong></td>
        <td>{{ number_format($total, 2) }}</td>
      </tr>
    </tfoot>
  </table>
</body>
</html>