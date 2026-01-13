<table class="data-table table table-bordered table-striped" style="margin-bottom: 0px;">
    <thead>
        <tr>
            <th>Nº</th>
            <th>Nombre</th>
            <th>Costo Bs.</th>
            <th>Disponible</th>
            <th>Ingresos</th>
            <th>Salidas</th>
            <th>Descripción</th>
            <th>Opciones</th>
        </tr>
    </thead>
    <tbody>
        @php
            $cont = $productos->firstItem();
        @endphp
        @foreach ($productos as $producto)
            <tr>
                <td>{{ $cont++ }}</td>
                <td>
                    {{ $producto->nom }}
                </td>
                <td>
                    {{ $producto->costo }}
                </td>
                <td>
                    {{ $producto->disponible }}
                </td>
                <td>
                    {{ $producto->ingresos }}
                </td>
                <td>
                    {{ $producto->salidas }}
                </td>
                <td>
                    {{ $producto->descripcion }}
                </td>
                <td class="btns-opciones">
                    @if (Auth::user()->tipo == 'ADMINISTRADOR')
                        <a href="{{ route('productos.edit', $producto->id) }}" class="modificar"><i class="fa fa-edit"
                                data-toggle="tooltip" data-placement="left" title="Modificar"></i></a>
                    @endif

                    <a href="" data-url="{{ route('productos.ingreso', $producto->id) }}" data-toggle="modal"
                        data-target="#modal-ingreso" class="ingreso evaluar"><i class="fa fa-plus" data-toggle="tooltip"
                            data-placement="left" title="Registrar ingreso"></i></a>

                    @if (Auth::user()->tipo == 'ADMINISTRADOR')
                        <a href="#" data-url="{{ route('productos.destroy', $producto->id) }}" data-toggle="modal"
                            data-target="#modal-eliminar" class="eliminar"><i class="fa fa-trash" data-toggle="tooltip"
                                data-placement="left" title="Eliminar"></i></a>
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
