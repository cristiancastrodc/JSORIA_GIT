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
  <h2>Institucion: {{$id_institucion}} - {{$nombre_nivel['nombre_division']}}</h2>
  <h2>Grado: {{$id_grado}}</h2>
   <!--Fecha con sus labes en 2 columnas--> 
  <h3>{{$fecha_inicio}} - {{$fecha_fin}}</h3>  
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
      <?php $i=1;?>
          @foreach($datas as $data)
      <tr>
      <td><?php echo $i?></td>
      <td>{{$data['nombres'] . '&nbsp;' . $data['apellidos']}}
      </td>
      <td>{{$data['nombre']}}
      </td>
      <td>{{$data['saldo'] - $data['descuento']}}
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