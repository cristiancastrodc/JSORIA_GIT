<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Reporte Ingresos por categoria</title>
    <link rel="stylesheet" href="{{ asset('css/reportes.css') }}">
  </head>
<body>
<div >
  <div class="header header-90">
    <table>
        <tr>
          <td colspan="3" class="text-center"><h1>INGRESOS POR CATEGORIA</h1>
            
          </td>
        </tr>  
        <tr>
          <td>Institucion: {{$id_institucion}} {{$nombre_nivel['nombre_division']}}</td>
        </tr>
        <tr>
          <td>Fecha Inicial: {{$fecha_inicio}}</td>
        </tr> 
        <tr>
          <td>Fecha Final: {{$fecha_fin}}</td>
        </tr>    
      </table>
      <hr>
  </div>
  <div class="footer">
    Página <span class="pagenum"></span>
  </div>   
  <div class="space-95"></div>  
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