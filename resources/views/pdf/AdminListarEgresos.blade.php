<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Reporte Lista Ingresos</title>
    {!! Html::style('css/pdf.css') !!}
  </head>
  <!--<body>

    <main>
      <div id="details" class="clearfix">
        <div id="invoice">
          <h1> {{ $id_institucion }}</h1>
          <div class="date">Date of Invoice: {{ $date }}</div>
        </div>
      </div>
      <table border="0" cellspacing="0" cellpadding="0">
        <thead>
          <tr>
            <th class="no">#</th>
            <th class="desc">TIPO COMPROBANTE</th>
            <th class="unit">NRO COMPROBANTE</th>
            <th class="total">FECHA</th>
            <th class="total">MONTO</th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <td colspan="3"></td>
            <td >TOTAL</td>
            <td>$6,500.00</td>
          </tr>
        </tfoot>
      </table>
  </body>-->
<body>
<div >
  <h1>LISTA DE EGRESOS</h1>
  <!--<h2>Institucion: {{$id_institucion}} - {{$nombre_nivel['nombre_division']}}</h2>-->
  <h2>Institucion: {{$id_institucion}}</h2>
   <!--Fecha con sus labes en 2 columnas--> 
  <h3>{{$fecha_inicio}} - {{$fecha_fin}}</h3>  
  <table >
    <thead>
      <tr>
        <td>#</td>
        <td>Tipo Comprobante</td>
        <td>Nro Comprobante</td>
        <td>Rubro</td>
        <td>Monto</td>
      </tr>
    </thead>
    <tbody>
      <?php $i=1;?>
          @foreach($datas as $data)
      <tr>
      <td><?php echo $i?></td>
      <td>{{$data['tipo_comprobante']}}
      </td>
      <td>{{$data['numero_comprobante']}}
      </td>
      <td>{{$data['nombre']}}
      </td>
      <td>{{$data['monto']}}
      </td>
    </tr>
    <?php $i++; ?>
    @endforeach
   
  </tbody>
        <tfoot>
          <tr>
            <td colspan="2"></td>
            <td >TOTAL</td>
            <td>$6,500.00</td>
          </tr>
        </tfoot>  
</table>
</div>

</body>   
</html>