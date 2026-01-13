<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <label>Nombre de promoción*</label>
        {{ Form::text('nom', null, ['class' => 'form-control', 'required', 'autofocus']) }}
    </div>
</div>
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <label>Indicar el rango</label><br>
        <small>En caso de querer indicar un rango sin limite de cantidad dejar el segundo campo vacío</small>
        <div class="input-group">
            <span class="input-group-addon">De</span>
            {{ Form::number('inicio', null, ['class' => 'form-control', 'min' => '1', 'required']) }}
            <span class="input-group-addon">a</span>
            {{ Form::number('fin', null, ['class' => 'form-control', 'min' => '1']) }}
            <span class="input-group-addon">productos</span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <div class="form-group">
            <label>Producto*:</label>
            {{ Form::select('producto_id', $array_productos, null, ['class' => 'form-control', 'required']) }}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <div class="form-group">
            <label>Descuento *:</label>
            {{ Form::select('descuento_id', $array_descuentos, null, ['class' => 'form-control', 'required']) }}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <label>Indicar el rango de duración*</label><br>
        <div class="input-group">
            <span class="input-group-addon">Del</span>
            {{ Form::date('fecha_inicio', isset($promocion) ? $promocion->fecha_ini : date('Y-m-d'), ['class' => 'form-control', 'required']) }}
            <span class="input-group-addon">al</span>
            {{ Form::date('fecha_fin', isset($promocion) ? $promocion->fecha_fin : date('Y-m-d', strtotime(date('Y-m-d') . '+1 day')), ['class' => 'form-control', 'required']) }}
        </div>
    </div>
</div>
