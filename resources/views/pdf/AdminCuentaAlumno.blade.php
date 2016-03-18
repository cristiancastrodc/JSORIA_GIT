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
  <h2>Alumno: {{$datas[1]['nombres'].' '.$datas[1]['apellidos']}}</h2>
  <h2>Institucion: {{$Institucion_alumno[0]['nombre'].' - '.$Institucion_alumno[0]['nombre_division']}}</h2>
  <table >
    <thead>
      <tr>
        <td>Nro</td>
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
      <td>{{$data['saldo'] - $data['descuento']}}
      <?php $total=$total+$data['saldo'] - $data['descuento']?>             
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