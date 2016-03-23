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
  <?php
  switch ($id_categoria) {
    case 'matricula':
      $id_categoria='Matriculas';
      break;
    case 'pension':
      $id_categoria='Matriculas';
      break;
    case 'actividad':
      $id_categoria='Actividades';
      break;
    case 'cobro_extraordinario':
      $id_categoria='Cobros Extraordinarios';
      break;
    case 'con_factor':
      $id_categoria='Cobro Con Facto';
      break;
    case 'sin_factor':
      $id_categoria='Cobro Sin Factor';
      break;
    case 'multiple':
      $id_categoria='Otros cobros';
      break;    
    default:      
      break;
  }
  ?>
  <?php if ($nombre_nivel['nombre_division']=='Todo'){
    $nombre_nivel['nombre_division']='';
  }
  else
  {
   $nombre_nivel['nombre_division'] = '- '.$nombre_nivel['nombre_division'];
  }
  ?>    
  <h2>Institucion: {{$id_institucion}} {{$nombre_nivel['nombre_division']}}</h2>
  <?php if ($var_checkbox_categorias=='true'){

  }
  else{?>
  <h2>Categoria: {{$id_categoria}}</h2>
  <?php
  }
  ?>
  <h2>Fecha Inicial: {{$fecha_inicio}}</h2>
  <h2>Fecha Final: {{$fecha_fin}}</h2>  
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
            <td ><b>TOTAL (S/)</b></td>
            <td><b><?php echo number_format($total,2); ?></b></td>
          </tr>
        </tfoot>  
</table>
</div>

</body>        

</html>