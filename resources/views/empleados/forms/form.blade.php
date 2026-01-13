<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label>Nombre(s)*:</label>
            <input type="text" name="nombre" value="{{ isset($empleado) ? $empleado->nombre : '' }}"
                class="form-control" required>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Paterno*:</label>
            <input type="text" name="paterno" value="{{ isset($empleado) ? $empleado->paterno : '' }}"
                class="form-control" required>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Materno:</label>
            <input type="text" name="materno" value="{{ isset($empleado) ? $empleado->materno : '' }}"
                class="form-control">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <label>Carnet de identidad*:</label>
        <input type="number" name="ci" value="{{ isset($empleado) ? $empleado->ci : '' }}" class="form-control"
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
            <option value="LP" {{ isset($empleado) && $empleado->ci_exp == 'LP' ? 'selected' : '' }}>LA PAZ</option>
            <option value="CB" {{ isset($empleado) && $empleado->ci_exp == 'CB' ? 'selected' : '' }}>COCHABAMBA
            </option>
            <option value="SC" {{ isset($empleado) && $empleado->ci_exp == 'SC' ? 'selected' : '' }}>SANTA CRUZ
            </option>
            <option value="PT" {{ isset($empleado) && $empleado->ci_exp == 'PT' ? 'selected' : '' }}>POTOSI</option>
            <option value="CH" {{ isset($empleado) && $empleado->ci_exp == 'CH' ? 'selected' : '' }}>CHUQUISACA
            </option>
            <option value="TJ" {{ isset($empleado) && $empleado->ci_exp == 'TJ' ? 'selected' : '' }}>TARIJA
            </option>
            <option value="BN" {{ isset($empleado) && $empleado->ci_exp == 'BN' ? 'selected' : '' }}>BENI</option>
            <option value="PD" {{ isset($empleado) && $empleado->ci_exp == 'PD' ? 'selected' : '' }}>PANDO</option>
            <option value="OR" {{ isset($empleado) && $empleado->ci_exp == 'OR' ? 'selected' : '' }}>ORURO</option>
        </select>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Dirección*:</label>
            <input type="text" name="dir" value="{{ isset($empleado) ? $empleado->dir : '' }}"
                class="form-control" required>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label>Correo*:</label>
            <input type="email" name="correo" value="{{ isset($empleado) ? $empleado->correo : '' }}"
                class="form-control" required>
            @if ($errors->has('correo'))
                <span class="invalid-feedback" style="color:red;" role="alert">
                    <strong>{{ $errors->first('correo') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Celular*:</label>
            <input type="text" name="cel" value="{{ isset($empleado) ? $empleado->cel : '' }}"
                class="form-control" required>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Teléfono:</label>
            <input type="text" name="fono" value="{{ isset($empleado) ? $empleado->fono : '' }}"
                class="form-control">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label>Rol*:</label>
            <input type="text" name="rol" value="{{ isset($empleado) ? $empleado->rol : '' }}"
                class="form-control" required>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Usuario*:</label>
            <select name="tipo" class="form-control" required>
                <option value="">Seleccione</option>
                <option value="ADMINISTRADOR"
                    {{ isset($empleado) && $empleado->user->tipo == 'ADMINISTRADOR' ? 'selected' : '' }}>ADMINISTRADOR
                </option>
                <option value="EMPLEADO"
                    {{ isset($empleado) && $empleado->user->tipo == 'EMPLEADO' ? 'selected' : '' }}>
                    EMPLEADO</option>
            </select>
        </div>
    </div>
    @if (isset($empleado))
        <div class="col-md-4 contenedor_foto">
            <img src="{{ asset('imgs/empleado/' . $empleado->foto) }}" width="150" height="155"
                id="imagen_select">
            <div class="form-group contenedor_subir">
                <input type="file" accept="image/*" style='opacity: 0;' name="foto" class="file" id="foto">
                <label class="subir"for="foto">
                    <i class="fa fa-image"></i> <span>Elegir foto</span>
                </label>
            </div>
        </div>
    @else
        <div class="col-md-4 contenedor_foto">
            <img src="{{ asset('imgs/users/user_default.png') }}" width="150" height="155" id="imagen_select">
            <div class="form-group contenedor_subir">
                <input type="file" accept="image/*" style='opacity: 0;' name="foto" class="file"
                    id="foto">
                <label class="subir"for="foto">
                    <i class="fa fa-image"></i> <span>Elegir foto</span>
                </label>
            </div>
        </div>
    @endif
</div>
