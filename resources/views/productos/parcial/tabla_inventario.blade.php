@php
    $contador = 1;
@endphp
<table class="tabla_inventario" border="1">
    <thead>
        <tr>
            <th class="centreado" width="6%">N°</th>
            <th class="centreado">Nombre Producto</th>
            <th class="centreado">Cantidad disponible</th>
            @if ($precio_total == "si")
                <th class="centreado">Precio Unitario Bs.</th>
                <th class="centreado">Total</th>
            @endif
        </tr>
    </thead>
    <tbody>
		@php
		$total_suma=0;
		@endphp
		@foreach ($productos as $producto)
            <tr>
                <td class="centreado">{{ $contador++ }}</td>
                <td>{{ $producto->nom }}</td>
                <td class="centreado">{{ $producto->disponible }}</td>
                @if ($precio_total == "si")
                    <td class="centreado">{{ $producto->costo }}</td>
                    @php
                        $total = (float) $producto->costo * (float) $producto->disponible;
						$total_suma += $total;
                    @endphp
                    <td class="centreado">{{ number_format($total, 2, '.', '') }}</td>
                @endif
            </tr>
        @endforeach
		@if($precio_total == "si")
		<tr>
			<th colspan="4">TOTAL</th>
			<th class="bold centreado">{{ number_format($total_suma, 2, '.', '') }}</th>
		</tr>
		@endif
    </tbody>
</table>
