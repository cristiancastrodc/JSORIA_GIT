<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Reporte Egresos Totales</title>
    {!! Html::style('css/pdf.css') !!}
  </head>
<body>
<div >
  <h1>EGRESOS POR {{$radio_btn_fecha}}</h1>
  <h2>Institucion: {{$id_institucion}}</h2>
  <h2>Fecha Inicial: {{$fecha_inicio}}</h2>
  <h2>Fecha Final: {{$fecha_fin}}</h2>  
  <table >
    <thead>
      <tr>
        <td>Nro</td>
        <td>Fecha</td>
        <td>Monto</td>
      </tr>
    </thead>
    <tbody>
      <?php $i=1;$total=0;?>
      @foreach($datas as $data)
      <tr>
      <td><?php echo $i?></td>
      <?php 
      if ($radio_btn_fecha=='MESES'){
        switch ($data['fecha1']) {
          case 1:
            $data['fecha1']='Enero - ';
            break;
          case 2:
            $data['fecha1']='Febrero - ';
            break;
          case 3:
            $data['fecha1']='Marzo - ';
            break;          
          case 4:
            $data['fecha1']='Abril - ';
            break;          
          case 5:
            $data['fecha1']='Mayo - ';
            break;          
          case 6:
            $data['fecha1']='Junio - ';
            break;          
          case 7:
            $data['fecha1']='Julio - ';
            break;          
          case 8:
            $data['fecha1']='Agosto - ';
            break;          
          case 9:
            $data['fecha1']='Septiembre - ';
            break;          
          case 10:
            $data['fecha1']='Octubre - ';
            break;          
          case 11:
            $data['fecha1']='Noviembre - ';
            break;          
          case 12:
            $data['fecha1']='Diciembre - ';
            break;          
          default:            
            break;
        };
      }
      ?>
      <td>{{$data['fecha1'] . $data['fecha2'] }}
      </td>
      <td>{{$data['montos']}}
      <?php $total=$total+$data['montos']?>      
      </td>
    </tr>
    <?php $i++; ?>
    @endforeach
   
  </tbody>
        <tfoot>
          <tr>
            <td colspan="1"></td>
            <td ><b>TOTAL (S/)</b></td>
            <td><b><?php echo number_format($total,2); ?></b></td>
          </tr>
        </tfoot>  
</table>
</div>

</body>
</html>