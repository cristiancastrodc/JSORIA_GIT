<div class="modal fade" id="modal-editar-c-ordinario" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Editar Cobro Ordinario</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <input type="hidden" value="{{ csrf_token() }}" name="_token" id="modal-token">
                    <input type="hidden" id="modal-id">
                    <div class="form-group">
                        <label for="monto" class="control-label col-sm-3">Monto:</label>
                        <div class="col-sm-9">
                            <div class="fg-line">
                                <input type="text" id="modal-monto" name="modal-monto" class="form-control">
                            </div>
                        </div>
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