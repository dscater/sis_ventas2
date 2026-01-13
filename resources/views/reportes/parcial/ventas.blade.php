@php
    $cont = 1;
    $suma_total = 0;
@endphp
@if (count($ventas) > 0)
    @foreach ($ventas as $venta)
        <tr>
            <td class="centreado text-center">{{ $cont++ }}</td>
            <td>
                @if ($venta->user->empleado)
                    {{ $venta->user->empleado->nombre }} {{ $venta->user->empleado->paterno }}
                    {{ $venta->user->empleado->materno }}
                @else
                    {{ $venta->user->name }}
                @endif
            </td>
            <td>
                {{ $venta->cliente->nombre }}
            </td>
            <td>
                {{ $venta->fecha_venta }}
            </td>
            <td class="derecha text-right">
                {{ $venta->total }}
            </td>
        </tr>
        @php
            $suma_total += (float) $venta->total;
        @endphp
    @endforeach
@else
    <tr>
        <td colspan="5" class="bold bold text-center centreado">SIN DATOS</td>
    </tr>
@endif
<tr>
    <td colspan="4" class="derecha bold gray bold text-right">TOTAL</td>
    <td class="derecha bold gray bold text-right">{{ number_format($suma_total, 2, '.', '') }}</td>
</tr>
