<table class="data-table table table-bordered table-hover">
    <thead>
        <tr>
            <th>Nº</th>
            <th>Producto</th>
            <th>C/U<br />Bs.</th>
            <th>Stock</th>
            <th></th>
        </tr>
    </thead>
    <tbody id="lista_productos">
        @php
            $cont = $productos->firstItem();
        @endphp
        @foreach ($productos as $producto)
            <tr class="fila" data-cod="{{ $producto->id }}"
                data-url="{{ route('productos.infoProducto', $producto->id) }}">
                <td>{{ $cont++ }}</td>
                <td>{{ $producto->nom }}</td>
                <td class="centreado">{{ $producto->costo }}</td>
                <td class="centreado">{{ $producto->disponible }}</td>
                <td class="btns-opciones">
                    @if ($producto->disponible > 0)
                        <a href="#" class="ir-evaluacion agregar"><i class="fa fa-plus" data-toggle="tooltip"
                                data-placement="left" title="Agregar"></i></a>
                    @else
                        <button class="ir-evaluacion agregar" disabled><i class="fa fa-plus" data-toggle="tooltip"
                                data-placement="left" title="Agregar"></i></button>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<div class="col-md-4">
    Mostrando {{ $productos->firstItem() ? $productos->firstItem() : 0 }}al {{ $productos->lastItem() }} de
    {{ $productos->total() }}
    registros.
</div>
<div class="col-md-6 col-md-offset-2 text-right">
    {!! $productos->links() !!}
</div>
