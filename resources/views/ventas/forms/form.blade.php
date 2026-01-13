@if (session('error_venta'))
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-danger">
                <button class="close" data-dismiss="alert">&times;</button>
                {{ session('error_venta') }}
            </div>
        </div>
    </div>
@endif

<div class="row">

    <!-- LISTA DE VIDEOS -->
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h2 class="titulo_panel">PRODUCTOS</h2>
            </div>
            <div class="panel-body contenedor_videos">
                <div class="row" style="margin-bottom:15px;">
                    <div class="col-md-4">
                        <select name="" id="per_page" class="form-control">
                            <option value="5">5 registros</option>
                            <option value="10" selected>10 registros</option>
                            <option value="20">20 registros</option>
                            <option value="50">50 registros</option>
                            <option value="100">100 registros</option>
                            <option value="200">200 registros</option>
                        </select>
                    </div>
                    <div class="col-md-6 col-md-offset-2">
                        <input type="text" class="form-control" placeholder="Buscar" id="search">
                    </div>
                </div>
                <div id="contenedor_registros"></div>
            </div>
        </div>
    </div>

    <!-- AGREGADOS -->
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h2 class="titulo_panel">LISTA</h2>
            </div>
            <div class="panel-body" style="overflow: auto;">
                <small><i>Los descuentos se aplican al C.U.</i></small><br>
                <p class="text-center" style="margin-bottom:0px;"><small>Expresado en Bolivianos</small></p>
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr class="header_detalle">
                            <th width="5%">Nº</th>
                            <th>Producto</th>
                            <th width="12%">Precio Unitario Bs.</th>
                            <th width="2%">Cantidad</th>
                            <th width="7%">Descuento Unitario</th>
                            <th width="2%">Sub Total Bs.</th>
                            <th width="2%"></th>
                        </tr>
                    </thead>
                    <tbody id="lista_detalle">
                        @if (isset($venta))
                            @foreach ($venta->detalles as $detalle)
                                <tr data-id="{{ $detalle->id }}" data-cod="{{ $detalle->producto->id }}"
                                    data-nombre="{{ $detalle->producto->nom }}" data-cost="{{ $detalle->costo }}"
                                    class="fila existe">
                                    <td>#</td>
                                    <td>{{ $detalle->producto->nom }}</td>
                                    <td class="centreado">{{ $detalle->costo }}</td>
                                    <td class="centreado">{{ $detalle->cantidad }}</td>
                                    <td class="centreado">{{ $detalle->descuento }} {{ $detalle->simbolo_tipo }}</td>
                                    <td class="centreado">{{ $detalle->total }}</td>
                                    <td class="centreado quitar"><span title="Quitar" class="eliminar"><i
                                                class="fa fa-times"></i></span></td>
                                </tr>
                            @endforeach
                        @else
                            <tr class="sin_registros">
                                <td colspan="7">NO HAY REGISTROS</td>
                            </tr>
                        @endif
                        <tr class="total">
                            <td colspan="3">TOTAL</td>
                            <td class="centreado">{{ isset($venta) ? $venta->detalles()->sum('cantidad') : 0 }}</td>
                            <td class="centreado"></td>
                            <td class="centreado">{{ isset($venta) ? $venta->total : '0.00' }}</td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
                <div class="col-md-12">
                    <table class="table_detalle_prestamo" style="border-collapse:separate;border-spacing: 10px;">
                        <tbody id="contenedorDetalle">
                            <tr>
                                <td><label>TOTAL FINAL:</label></td>
                                <td><input type="text" class="form-control"
                                        value="{{ isset($venta) ? $venta->total : '0.00' }}" id="total_final" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td><label>CLIENTE:</label></td>
                                <td>
                                    <select name="" id="cliente" class="form-control">
                                        @foreach ($array_clientes as $key => $item)
                                            <option value="{{ $key }}"
                                                {{ isset($venta) && $venta->cliente_id == $key ? 'selected' : '' }}>
                                                {{ $item }}</option>
                                        @endforeach
                                    </select>
                            </tr>
                            {{-- <tr>
                                    <td><label>NIT/C.I.:</label><small>(Obligatorio)</small></td>
                                    <td><input type="text" class="form-control" value="" id="nit"></td>
                                </tr> --}}
                            <tr>
                                <td><label>FECHA DE VENTA:</label></td>
                                <td><input type="date" class="form-control"
                                        value="{{ isset($venta) ? $venta->fecha_venta : date('Y-m-d') }}"
                                        id="fecha_venta" readonly></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="alert alert-danger oculto" id="error-fechas"></div>
                    <br>
                    <div class="col-md-12">
                        <button class="btn btn-success d-block" id="registrarVenta"
                            style="width:100%;">{!! isset($venta) ? '<i class="fa fa-edit"></i> Actualizar Venta' : '<i class="fa fa-save"></i> Registrar venta' !!}</button>
                    </div>
                </div>
                <div class="row error_venta oculto">
                    <div class="col-md-12" style="margin-top:15px;">
                        <div class="alert alert-danger">
                            {{-- <button class="close" data-dismiss="alert">&times;</button> --}}
                            <span id="message_error"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
