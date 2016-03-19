<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Reporte Egresos por Rubro</title>
    {!! Html::style('css/pdf.css') !!}
  </head>
  <body>
<div >
  <h1>LISTA DE EGRESOS POR RUBRO </h1>
  <h2>Institucion: {{$id_institucion}}</h2>
  <h2>Fecha Inicial: {{$fecha_inicio}}</h2>
  <h2>Fecha Final: {{$fecha_fin}}</h2>  
  <table >
    <thead>
      <tr>
        <td>Nro</td>
        <td>Rubro</td>
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
            <td colspan="1"></td>
            <td ><b>TOTAL (S/)</b></td>
            <td><b><?php echo number_format($total,2); ?></b></td>
          </tr>
        </tfoot>  
</table>
</div>

</body> 
</html>