<div class="modal fade" id="modal-editar-actividad" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Editar actividad</h4>
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
                        <label for="nombre" class="control-label col-sm-3">Nombre:</label>
                        <div class="col-sm-9">
                            <div class="fg-line">
                                <input type="text" name="nombre" id="modal-nombre" class="form-control">
                            </div>
                        </div>
                    </div>
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
