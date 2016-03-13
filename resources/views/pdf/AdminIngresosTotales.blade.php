<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Reporte Ingresos Totales</title>
    {!! Html::style('css/pdf.css') !!}
  </head>
  <body>

    <main>
      <div id="details" class="clearfix">
        <div id="invoice">
          <h1>INVOICE {{ $id_institucion }}</h1>
          <div class="date">Date of Invoice: {{ $date }}</div>
        </div>
      </div>
      <table border="0" cellspacing="0" cellpadding="0">
        <thead>
          <tr>
            <th class="no">#</th>
            <th class="desc">FECHA</th>
            <th class="unit">MONTO</th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <td colspan="0"></td>
            <td >TOTALasd</td>
            <td>$6,500.00</td>
          </tr>
        </tfoot>
      </table>
  </body>
</html>