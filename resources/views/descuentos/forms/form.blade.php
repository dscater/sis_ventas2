<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>
                Nombre*
            </label>
            <input type="text" name="nom" value="{{ isset($descuento) ? $descuento->nom : '' }}" class="form-control"
                required>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>
                Descuento*
            </label>
            <input type="number" min="0" step="0.01" name="descuento"
                value="{{ isset($descuento) ? $descuento->descuento : '' }}" class="form-control" required>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>
                Tipo*
            </label>
            <select name="tipo" class="form-control" required>
                <option value="">Seleccione</option>
                <option value="BS" {{ isset($descuento) && $descuento->tipo == 'BS' ? 'selected' : '' }}>Bolivianos
                    (Bs)
                </option>
                <option value="P" {{ isset($descuento) && $descuento->tipo == 'P' ? 'selected' : '' }}>Porcentaje
                    (%)
                </option>
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>
                Descripción*
            </label>
            <input type="text" name="descripcion" value="{{ isset($descuento) ? $descuento->descripcion : '' }}"
                class="form-control" required>
        </div>
    </div>
</div>
