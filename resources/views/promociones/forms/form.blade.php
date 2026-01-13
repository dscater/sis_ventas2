<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <label>Nombre de promoción*</label>
        <input type="text" name="nom" class="form-control" required autofocus>
    </div>
</div>
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <label>Indicar el rango</label><br>
        <small>En caso de querer indicar un rango sin limite de cantidad dejar el segundo campo vacío</small>
        <div class="input-group">
            <span class="input-group-addon">De</span>
            <input type="number" name="inicio" min="1" class="form-control" required>
            <span class="input-group-addon">a</span>
            <input type="number" name="fin" min="1" class="form-control">
            <span class="input-group-addon">productos</span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <div class="form-group">
            <label>Seleccione los productos*:</label>
            <select name="producto_id[]" class="form-control multiselect" required multiple>
                <option value="">Seleccione</option>
                @foreach ($array_productos as $key => $item)
                    <option value="{{ $key }}">{{ $item }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <div class="form-group">
            <label>Descuento *:</label>
            <select name="descuento_id" class="form-control" required>
                <option value="">Seleccione</option>
                @foreach ($array_descuentos as $key => $item)
                    <option value="{{ $key }}">{{ $item }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <label>Indicar el rango de duración*</label><br>
        <div class="input-group">
            <span class="input-group-addon">Del</span>
            <input type="date" name="fecha_inicio"
                value="{{ isset($promocion) ? $promocion->fecha_ini : date('Y-m-d') }}" class="form-control">
            <span class="input-group-addon">al</span>

            <input type="date" name="fecha_fin"
                value="{{ isset($promocion) ? $promocion->fecha_fin : date('Y-m-d', strtotime(date('Y-m-d') . '+1 day')) }}"
                class="form-control">
        </div>
    </div>
</div>
