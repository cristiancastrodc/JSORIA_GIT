<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Reporte Cuenta Alumno</title>
    {!! Html::style('css/pdf.css') !!}
    </style>

  </head>
<body>
<div >
  <h1>Cuenta Alumno</h1>
  <h2>{{$datas[1]['nombres'].' '.$datas[1]['apellidos']}}</h2>
  <table >
    <thead>
      <tr>
        <td>#</td>
        <td>Categoria</td>
        <td>Monto</td>
      </tr>
    </thead>
    <tbody>
      <?php $i=1;?>
          @foreach($datas as $data)
      <tr>
      <td><?php echo $i?></td>
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