<div class="modal modal-danger fade" id="modal-ingreso">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Registrar ingresos</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form action="" id="formRegistraIngreso" method="post">
                        @csrf
                        <div class="col-md-12">
                            <label id="nomProducto"></label>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Cantidad*</label>
                                <input type="number" name="cantidad" value="1" id="cantidadIngreso" min="1"
                                    class="form-control">
                                <div class="error oculto" id="errorVacio">Debes indicar un valor</div>
                                <div class="error oculto" id="errorCero">Debes indicar un valor mayor a 0</div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-outline" id="btnRegistraIngreso">Registrar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
