<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Reporte Lista Ingresos</title>
    {!! Html::style('css/pdf.css') !!}
    </style>

  </head>
  <!--<body>

    <main>
      <div id="details" class="clearfix">
        <div id="invoice">
          <h1>INVOICE {{ $id_institucion }}</h1>
          <div class="date">Date of Invoice: </div>
        </div>
      </div>
        <table border="0" cellspacing="0" cellpadding="0">
          <thead>
            <tr>
            <th class="no">#</th>
            <th class="desc">HORA INGRESO</th>
            <th class="unit">CLIENTE</th>
            <th class="total">CATEGORIA</th>
            <th class="total">MONTO</th>
          </tr>
          </thead>
          <tbody>
          <?php for($i=0;$i<15;$i++)
          {
            ?>

          <tr >
            <td class="no">1</td>
            <td class="desc">2</td>
            <td class="unit">3</td>
            <td class="total">4 </td>
          </tr>            

                    <?php } ?>
          </tbody>
          <tbody>
          <?php for($i=0;$i<15;$i++)
          {
            ?>

          <tr >
            <td class="no">1</td>
            <td class="desc">2</td>
            <td class="unit">3</td>
            <td class="total">4 </td>
          </tr>            

                    <?php } ?>
          </tbody>          

        </table>-->
<body>
<div >
  <h1>{{$id_institucion}}</h1>
  <table >
    <thead>
      <tr>
        <td>#</td>
        <td>Fecha Hora Ingreso</td>
        <td>Alumno</td>
        <td>Cliente</td>
        <td>Nombre</td>
        <td>Monto</td>
      </tr>
    </thead>
    <tbody>
      <?php $i=1;?>
          @foreach($datas as $data)
      <tr>
      <td><?php echo $i?></td>
      <td>{{$data['nombre_division']}}
      </td>
      <td>{{$data['id_alumno']}}
      </td>
      <td>{{$data['cliente_extr']}}
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


  </body>
</html>