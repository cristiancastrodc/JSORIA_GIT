<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Reporte Lista Ingresos</title>
    <link rel="stylesheet" href="{{ asset('css/reportes.css') }}">
  </head>
<body>
  <div class="header header-90">
    <table>
        <tr>
          <td colspan="5" class="text-center"><h1>LISTA DE EGRESOS</h1></td>
        </tr>  
        <tr>
          <td>Institucion: {{$id_institucion}}</td>
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
  <div class="space-75"></div>
  <table>
    <thead>
      <tr>
        <td>Fecha</td>
        <td>Tipo Comprobante</td>
        <td>Nro Comprobante</td>
        <td>Rubro</td>
        <td>Monto</td>
      </tr>
    </thead>
    <tbody>
      <?php $i=1;$total=0.00;?>
          @foreach($datas as $data)
      <tr>
      <?php 
        switch ($data['tipo_comprobante']) {
          case 1:
            $data['tipo_comprobante']='Boleta';
            break;
          case 2:
            $data['tipo_comprobante']='Factura';
            break;
          case 3:
            $data['tipo_comprobante']='Comprobante de Pago';
            break;
          case 4:
            $data['tipo_comprobante']='Comprobante de Egreso';
            break;          
          case 5:
            $data['tipo_comprobante']='Recibo por Honorarios';
            break;          
          default:            
            break;
        };
      ?>      
      <td>{{$data['fecha_registro']}}
      </td>
      <td>{{$data['tipo_comprobante']}}
      </td>
      <td>{{$data['numero_comprobante']}}
      </td>
      <td>{{$data['nombre']}}
      </td>
      <td>{{$data['monto']}}
      <?php $total=$total+$data['monto']; ?>            
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