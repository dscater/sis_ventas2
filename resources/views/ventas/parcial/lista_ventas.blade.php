<table class="data-table table table-bordered table-striped" style="margin-bottom: 0px;">
    <thead>
        <tr>
            <th>Nº</th>
            <th>Empleado</th>
            <th>Cliente</th>
            <th>Fecha</th>
            <th>Total Bs.</th>
            <th>Opciones</th>
        </tr>
    </thead>
    <tbody>
        @php
            $cont = $ventas->firstItem();
        @endphp
        @foreach ($ventas as $venta)
            <tr>
                <td>{{ $cont++ }}</td>
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
                    {{ $venta->fecha_venta_txt }}
                </td>
                <td>
                    {{ $venta->total }}
                </td>
                <td class="btns-opciones">
                    <a href="{{ route('ventas.edit', $venta->id) }}" data-url="{{ route('ventas.edit', $venta->id) }}"
                        class="modificar"><i class="fa fa-edit" data-toggle="tooltip" data-placement="left"
                            title="Editar"></i></a>
                    @if (Auth::user()->tipo == 'ADMINISTRADOR')
                        <a href="#" data-url="{{ route('ventas.destroy', $venta->id) }}" data-toggle="modal"
                            data-target="#modal-eliminar" class="eliminar"><i class="fa fa-trash" data-toggle="tooltip"
                                data-placement="left" title="Eliminar"></i></a>
                    @endif
                    <a href="{{ route('ventas.show', $venta->id) }}" class="evaluar ver"><i class="fa fa-eye"
                            data-toggle="tooltip" data-placement="left" title="Ver información"></i></a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<div class="col-md-4">
    Mostrando {{ $ventas->firstItem() ? $ventas->firstItem() : 0 }} al {{ $ventas->lastItem() }} de
    {{ $ventas->total() }}
    registros.
</div>
<div class="col-md-6 col-md-offset-2 text-right">
    {!! $ventas->links() !!}
</div>
