<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Reporte Lista de Cobros del Dia</title>
    {!! Html::style('css/pdf.css') !!}
  </head>
  <body>
<div >
  <h1>LISTA DE COBROS DEL DIA</h1>
  <h2>Fecha: {{$today}}</h2>
  <table >
    <thead>
      <tr>
        <td>Nro</td>
        <td>Alumno</td>
        <td>Cliente</td>
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
            <td colspan="3"></td>
            <td ><b>TOTAL (S/)</b></td>
            <td><b><?php echo number_format($total,2); ?></b></td>
          </tr>
        </tfoot>  
</table>
</div>

</body> 

</html>