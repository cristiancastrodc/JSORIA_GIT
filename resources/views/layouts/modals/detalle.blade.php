<div class="modal fade" id="modal-detalle" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Cobros</h4>
            </div>
            <div class="modal-body">
                <div id="modal-error" style="display:none">
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <div id="message"></div>
                    </div>
                </div>
                <form class="form-horizontal" id="form-detalleCobro">
                    <input type="hidden" value="{{ csrf_token() }}" name="_token" id="modal-token">
                    <div class="table-responsive">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th class="warning c-white">Fecha - Hora</th>
                                  <th class="warning c-white">Alumno</th>
                                  <th class="warning c-white">Cliente</th>
                                  <th class="warning c-white">Categoria</th>
                                  <th class="warning c-white">Monto (S/)</th>
                        </tr>
                      </thead>
                      <tbody>                       
                      </tbody>
                    </table>
          </div>
                </form>
            </div>
            <div class="modal-footer">
                <a class="btn btn-link" data-dismiss="modal">Cerrar</a>
                <a class="btn btn-danger" id="modal-guardar">Guardar</a>
            </div>
        </div>
    </div>
</div>