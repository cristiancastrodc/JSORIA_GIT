<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Reporte Alumnos Deudores</title>
    {!! Html::style('css/pdf.css') !!}
  </head>
  <body>
<div >
  <h1>LISTA DE ALUMNOS DEUDORES</h1>
  <?php if ($nombre_nivel['nombre_division']=='Todo'){
    $nombre_nivel['nombre_division']='';?>
  <h2>Institucion: {{$id_institucion}} {{$nombre_nivel['nombre_division']}}</h2>
  <?php
  }
  else
  {
   $nombre_nivel['nombre_division'] = '- '.$nombre_nivel['nombre_division'];?>
  <h2>Institucion: {{$id_institucion}} {{$nombre_nivel['nombre_division']}}</h2>
  <h2>Grado: {{$id_grado['nombre_grado']}}</h2>
  <?php
  }
  ?>  
  <table >
    <thead>
      <tr>
        <td>#</td>
        <td>Alumno</td>
        <td>Categoria</td>
        <td>Monto</td>
      </tr>
    </thead>
    <tbody>
      <?php $i=1;$total=0;?>
          @foreach($datas as $data)
      <tr>
      <td><?php echo $i?></td>
      <td>{{$data['nombres'] . '&nbsp;' . $data['apellidos']}}
      </td>
      <td>{{$data['nombre']}}
      </td>
      <td>{{$data['saldo'] - $data['descuento']}}
      <?php $total=$total+$data['saldo'] - $data['descuento']?>       
      </td>
    </tr>
    <?php $i++; ?>
    @endforeach
   
  </tbody>
        <tfoot>
          <tr>
            <td colspan="2"></td>
            <td ><b>TOTAL (S/)</b></td>
            <td><b><?php echo number_format($total,2); ?></b></td>
          </tr>
        </tfoot>  
</table>
</div>

</body> 

</html>