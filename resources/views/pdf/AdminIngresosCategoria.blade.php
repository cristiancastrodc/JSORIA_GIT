<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Reporte Ingresos por categoria</title>
    {!! Html::style('css/pdf.css') !!}
  </head>
<body>
<div >
  <h1>INGRESOS POR CATEGORIA</h1>
  <h2>Institucion: {{$id_institucion}} - {{$nombre_nivel['nombre_division']}}</h2>
  <table >
    <tr >
    <td>Fecha Inicial:{{$fecha_inicio}}</td>
    <td>Fecha Final: {{$fecha_inicio}}</td>
    </tr>
  </table>
  <table >
    <thead>
      <tr>
        <td>#</td>
        <td>Categoria</td>
        <td>Monto</td>
      </tr>
    </thead>
    <tbody>
      <?php $i=1;$total=0;?>
          @foreach($datas as $data)
      <tr>
      <td><?php echo $i?></td>
      <td>{{$data['nombre']}}
      </td>
      <td>{{$data['monto']}}
      <?php $total=$total+$data['monto']?>
      </td>
    </tr> 
    <?php $i++; ?>
    @endforeach
   
  </tbody>
        <tfoot>
          <tr>
            <td colspan="2"></td>
            <td >TOTAL</td>
            <td><b><?php echo $total;?></b></td>
          </tr>
        </tfoot>  
</table>
</div>

</body>        
</html>