<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Reporte Ingresos Totales</title>
    {!! Html::style('css/pdf.css') !!}
  </head>
<body>
<div >
  <h1>{{$id_institucion}}</h1>
  <h2>{{$date}}</h2>
  <table >
    <thead>
      <tr>
        <td>#</td>
        <td>Fecha</td>
        <td>Monto</td>
      </tr>
    </thead>
    <tbody>
      <?php $i=1;?>
          @foreach($datas as $data)
      <tr>
      <td><?php echo $i?></td>
      <td>1
      </td>
      <td>2
      </td>
      <td>3
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