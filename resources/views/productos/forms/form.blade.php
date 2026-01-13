<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label>Nombre*</label>
            <input type="text" name="nom" value="{{ isset($producto) ? $producto->nom : '' }}" class="form-control"
                required>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Costo Bs.*</label>
            <input type="number" step="0.01" name="costo" value="{{ isset($producto) ? $producto->costo : '' }}"
                class="form-control" required>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Ingresa*</label>
            <input type="number" step="1" name="ingresos" value="{{ isset($producto) ? $producto->ingresos : '' }}"
                min="0" class="form-control" required>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label>Descripción</label>
            <input type="text" name="descripcion" value="{{ isset($producto) ? $producto->descripcion : '' }}"
                class="form-control">
        </div>
    </div>
</div>
