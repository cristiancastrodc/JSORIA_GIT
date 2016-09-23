<div class="modal fade" id="modal-resumen-pago" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Resumen de pago</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal">
          <?php if (Config::get('config.usar_facturas')): ?>
            <div class="form-group">
              <label for="ruc_cliente" class="control-label col-sm-3">RUC:</label>
              <div class="col-sm-9">
                <div class="fg-line"><input type="text" class="form-control" id="ruc_cliente" placeholder="Solo ingresar en caso de factura"></div>
              </div>
            </div>
            <div class="form-group">
              <label for="razon_social" class="control-label col-sm-3">Razón Social:</label>
              <div class="col-sm-9">
                <div class="fg-line"><input type="text" class="form-control" id="razon_social" placeholder="Solo ingresar en caso de factura"></div>
              </div>
            </div>
            <div class="form-group">
              <label for="direccion" class="control-label col-sm-3">Dirección:</label>
              <div class="col-sm-9">
                <div class="fg-line"><input type="text" class="form-control" id="direccion" placeholder="Solo ingresar en caso de factura"></div>
              </div>
            </div>
          <?php endif ?>
          <div class="table-responsive">
              <table id="tabla-resumen" class="table table-striped">
                  <thead>
                      <tr>
                          <th class="hidden">Id</th>
                          <th class="accent-color c-white">Concepto</th>
                          <th class="accent-color c-white">Monto (S/)</th>
                      </tr>
                  </thead>
                  <tbody></tbody>
              </table>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <!-- /cajera/imprimir -->
      </div>
    </div>
  </div>
</div>
