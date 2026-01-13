<div class="modal modal-danger fade" id="modal-agregar">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Agregar producto</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="url_info" readonly>
                <input type="hidden" id="data_cod" readonly>
                <input type="hidden" id="stock_disponible" readonly>
                <p><b>Producto: </b> <span id="nombre_producto"></span></p>
                <label>Cantidad*:</label>
                <input type="number" min="1" value="1" name="cantidad_productos" id="cantidad_productos" class="form-control">
                <div class="oculto error" id="error-cantidad">Debes indicar la cantidad</div>
                <div class="oculto error" id="error-stock">La cantidad indicada supera al stock disponible</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal" id="CancelarAgregar">Cancelar</button>
                <button type="button" class="btn btn-success" id="btnAgregarProducto">Agregar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>