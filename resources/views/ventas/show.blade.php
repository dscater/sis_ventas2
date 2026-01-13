@extends('layouts.admin')

@section('pagina')
    Información venta
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/vistas/ventas/ver_venta.css') }}">
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                {{-- <h3 class="titulo_form">VENTAS</h3> --}}
            </div>

            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="titulo_panel">PROFORMA DE VENTA</h2>
                    </div>
                    <div class="panel-body">
                        @php
                            $empresa = App\Models\Empresa::first();
                        @endphp
                        <div class="row">
                            <div class="col-md-12">
                                <img src="{{ asset('imgs/empresa/' . $empresa->logo) }}" class="logo_factura"
                                    alt="Logo">
                                <div class="titulo_derecha">
                                    <div class="contenedor_info">
                                        <p class="info"><strong>PROFORMA N°:
                                                {{ $venta->nro_factura }}</strong><span></span></p>
                                        <p class="info">{{ $empresa->name }} - {{ $empresa->pais }}</p>
                                        <p class="info">{{ date('d/m/Y', strtotime($venta->fecha_venta)) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <p style="margin-bottom: 2px; margin-top:30px;" class="bold">Original</p>
                                <div class="datos_factura">
                                    <div class="facturar_a">
                                        <p><strong>{{ $venta->cliente->nombre }}</strong> </p>
                                        <p>{{ $empresa->ciudad }}, {{ $empresa->dpto }} ({{ $empresa->pais }})</p>
                                        <p>Código de Cliente: {{ $venta->cliente->ci }}</p>
                                        <p>Cel.: {{ $venta->cliente->cel }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="factura">
                                    <thead class="border-top border-bottom">
                                        <tr>
                                            <th>N°</th>
                                            <th>Descripción</th>
                                            <th>Precio Unitario Bs.</th>
                                            <th>Cantidad</th>
                                            <th>Descuento Bs.</th>
                                            <th>Sub Total Bs.</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $cont = 1;
                                        $total_productos = 0;
                                        $total_descuentos = 0;
                                        $descuento = 0;
                                        ?>
                                        @foreach ($venta->detalles as $detalle)
                                            @php
                                                if ($detalle->tipo == 'BS') {
                                                    $descuento =
                                                        (float) $detalle->descuento * (float) $detalle->cantidad;
                                                } else {
                                                    $descuento =
                                                        $detalle->costo *
                                                        ((float) $detalle->descuento / 100) *
                                                        (float) $detalle->cantidad;
                                                }
                                            @endphp
                                            <tr>
                                                <td>{{ $cont++ }}</td>
                                                <td>{{ $detalle->producto->nom }}</td>
                                                <td>{{ $detalle->costo }}</td>
                                                <td>{{ $detalle->cantidad }}</td>
                                                <td>{{ number_format($descuento, 2) }}
                                                </td>
                                                <td>{{ $detalle->total }}</td>
                                            </tr>
                                            @php
                                                $total_productos += (int) $detalle->cantidad;
                                                $total_descuentos += (float) $descuento;
                                            @endphp
                                        @endforeach

                                        <tr class="total_final">
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td class="derecha bold border-top">
                                                TOTAL
                                            </td>
                                            <td class="bold border-top">{{ $total_productos }}</td>
                                            {{-- <td class="bold border-top">{{ number_format($total_descuentos, 2) }}</td> --}}
                                            <td class="derecha bold border-top border-bottom">&nbsp;</td>
                                            <td class="bold border-top">
                                                Bs. {{ $venta->total }}
                                            </td>
                                        </tr>
                                        <tr class="total_final">
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td class="derecha bold border-top border-bottom">
                                                TOTAL FINAL
                                            </td>
                                            <td class="derecha bold border-top border-bottom">&nbsp;</td>
                                            <td class="border-top border-bottom">&nbsp;</td>
                                            <td class="bold border-top border-bottom">
                                                Bs. {{ $venta->total_final }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="info1">

                                </div>
                                <div class="info2">

                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <a href="{{ route('ventas.index') }}" class="btn btn-default"><i
                                        class="fa fa-arrow-left"></i> Lista de Ventas</a>
                                @if (Auth::user()->tipo == 'ADMINISTRADOR')
                                    <button type="button" data-url="{{ route('ventas.destroy', $venta->id) }}"
                                        data-toggle="modal" data-target="#modal-eliminar" class="btn btn-danger"
                                        id="btnAbreModalEliminar"><i class="fa fa-trash"></i>
                                        Eliminar</button>
                                @endif
                                <a href="{{ route('ventas.edit', $venta->id) }}" class="btn btn-warning"><i
                                        class="fa fa-edit"></i> Editar</a>
                                <a href="{{ route('ventas.factura', $venta->id) }}" target="_blank"
                                    class="btn btn-success"><i class="fa fa-file-pdf"></i> Exportar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('modal.eliminar')
@endsection

@section('scripts')
    <script>
        // ELIMINAR
        $('#btnAbreModalEliminar').click(function(e) {
            e.preventDefault();
            $('#mensajeEliminar').addClass("text-center");
            $('#mensajeEliminar').html(
                `¿Está seguro(a) de eliminar la venta?`
            );
            let url = $(this).attr('data-url');
            $('#formEliminar').prop('action', url);
        });

        $('#btnEliminar').click(function() {
            $('#formEliminar').submit();
        });
    </script>
@endsection
