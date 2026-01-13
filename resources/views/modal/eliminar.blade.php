<div class="modal modal-danger fade" id="modal-eliminar">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Eliminar registro</h4>
            </div>
            <div class="modal-body">
                <form action="" id="formEliminar" method="post">
                    @csrf
                    <input type="hidden" name="_method" value="delete">
                </form>
                <p id="mensajeEliminar"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-outline" id="btnEliminar">Sí, eliminar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
