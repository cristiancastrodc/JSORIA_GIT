<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Reporte Lista Ingresos</title>
    {!! Html::style('css/pdf.css') !!}
    </style>

  </head>
<body>
<div >
  <h1>LISTA DE INGRESOS</h1>

  <h2>Institucion: {{$id_institucion}} - {{$nombre_nivel['nombre_division']}}</h2>
  <h2>Categoria: {{$id_categoria}}</h2>
  <table >
    <tr >
    <td>Fecha Inicial:{{$fecha_inicio}}</td>
    <td>Fecha Final: {{$fecha_inicio}}</td>
    </tr>
  </table>
     <!--Fecha con sus labes en 2 columnas--> 
  <table >
    <thead>
      <tr>
        <td>Nro</td>
        <td>Fecha Hora Ingreso</td>
        <td>Alumno</td>
        <td>Cliente</td>
        <td>Nombre</td>
        <td>Monto</td>
      </tr>
    </thead>
    <tbody>
      <?php $i=1;$total=0;?>
          @foreach($datas as $data)
      <tr>
      <td><?php echo $i?></td>
      <td>{{$data['fecha_hora_ingreso']}}
      </td>
      <td>{{$data['id_alumno']}}
      </td>
      <td>{{$data['cliente_extr']}}
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
            <td colspan="4"></td>
            <td ><b>TOTAL</b></td>
            <td><b><?php echo $total;?></b></td>
          </tr>
        </tfoot>  
</table>
</div>

</body>        

</html>