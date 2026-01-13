<div class="modal modal-danger fade" id="modal-asignar">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Asignar contraseña</h4>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="formAsignar">
                    @csrf
                    <p><b>Empleado:</b> <span id="nombreEmpleado"></span></p>
                    <label>Contraseña*:</label>
                    <input type="text" name="password" id="new_password" class="form-control">
                    <div class="error oculto" id="error_contrasena">Debes indicar una contraseña</div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal"
                    id="CancelarAsignacion">Cancelar</button>
                <button type="button" class="btn btn-success" id="btnAsignar">Asignar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
