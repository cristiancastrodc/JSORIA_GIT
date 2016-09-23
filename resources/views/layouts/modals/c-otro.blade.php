<div class="modal fade" id="modal-editar-c-otro" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Editar Cobro</h4>
            </div>
            <div class="modal-body">
                <div id="modal-error" style="display:none">
                  <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <div id="message"></div>
                  </div>
                </div>
                <form class="form-horizontal">
                    <input type="hidden" value="{{ csrf_token() }}" name="_token" id="modal-token">
                    <input type="hidden" id="modal-id">
                    <div class="form-group">
                        <label for="modal-nombre" class="col-sm-3 control-label">Concepto</label>
                        <div class="col-sm-9">
                            <div class="fg-line">
                                <input type="text" class="form-control input-sm" id="modal-nombre" name="modal-nombre" placeholder="Concepto">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="modal-monto" class="col-sm-3 control-label">Monto</label>
                        <div class="col-sm-9">
                            <div class="fg-line">
                                <input type="text" class="form-control input-sm" id="modal-monto" name="modal-monto" placeholder="Monto">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="modal-estado" class="col-sm-3 control-label">¿Habilitar?</label>
                        <div class="col-sm-9">
                            <div class="toggle-switch">
                                <label for="modal-estado" class="ts-label"></label>
                                <input id="modal-estado" name="modal-estado" type="checkbox" hidden="hidden">
                                <label for="modal-estado" class="ts-helper"></label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <a class="btn btn-link" data-dismiss="modal">Cerrar</a>
                <a class="btn accent-color" id="modal-guardar">Guardar</a>
            </div>
        </div>
    </div>
</div>
