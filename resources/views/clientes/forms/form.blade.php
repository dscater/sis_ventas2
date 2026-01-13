<div class="row">
    <div class="col-md-4">
        <label>Nombre completo*</label>
        <input type="text" name="nombre" value="{{ isset($cliente) ? $cliente->nombre : '' }}" class="form-control"
            required autofocus>
    </div>
    <div class="col-md-3">
        <label>Carnet de identidad*:</label>
        <input type="number" name="ci" value="{{ isset($cliente) ? $cliente->ci : '' }}" class="form-control"
            required>
        @if ($errors->has('ci'))
            <span class="invalid-feedback" style="color:red;" role="alert">
                <strong>{{ $errors->first('ci') }}</strong>
            </span>
        @endif
    </div>
    <div class="col-md-2">
        <label>Expedido*:</label>
        <select name="ci_exp"class="form-control" required>
            <option value="">Seleccione</option>
            <option value="LP" {{ isset($cliente) && $cliente->ci_exp == 'LP' ? 'selected' : '' }}>LA PAZ</option>
            <option value="CB" {{ isset($cliente) && $cliente->ci_exp == 'CB' ? 'selected' : '' }}>COCHABAMBA
            </option>
            <option value="SC" {{ isset($cliente) && $cliente->ci_exp == 'SC' ? 'selected' : '' }}>SANTA CRUZ
            </option>
            <option value="PT" {{ isset($cliente) && $cliente->ci_exp == 'PT' ? 'selected' : '' }}>POTOSI</option>
            <option value="CH" {{ isset($cliente) && $cliente->ci_exp == 'CH' ? 'selected' : '' }}>CHUQUISACA
            </option>
            <option value="TJ" {{ isset($cliente) && $cliente->ci_exp == 'TJ' ? 'selected' : '' }}>TARIJA
            </option>
            <option value="BN" {{ isset($cliente) && $cliente->ci_exp == 'BN' ? 'selected' : '' }}>BENI</option>
            <option value="PD" {{ isset($cliente) && $cliente->ci_exp == 'PD' ? 'selected' : '' }}>PANDO</option>
            <option value="OR" {{ isset($cliente) && $cliente->ci_exp == 'OR' ? 'selected' : '' }}>ORURO</option>
        </select>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Celular*:</label>
            <input type="text" name="cel" value="{{ isset($cliente) ? $cliente->cel : '' }}"
                class="form-control" required>
        </div>
    </div>
</div>
