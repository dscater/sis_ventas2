<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Factura</title>
    <style>
        * {
            /* font-family: Trebuchet MS; */
        }

        @page {
            margin-left: 0.5cm;
            margin-top: 0.5cm;
            margin-right: 0.5cm;
            margin-bottom: 0.5cm;
            size: 11cm 27.94cm;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            position: relative;
        }

        table {
            page-break-before: avoid;
        }

        .encabezado {
            width: 100%;
            border: solid 1px rgb(241, 245, 248);
            padding: 12px 5px;
            font-size: 0.8em;
            font-weight: bold;
        }

        .titulo {
            margin-right: auto;
            margin-left: auto;
            margin-bottom: auto;
            width: 300px;
        }

        .titulo p.emp {
            text-align: center;
            font-size: 1.05em;
            padding: 0;
            margin-bottom: -10px;
        }

        .titulo p.dir {
            text-align: center;
            font-size: 0.60em;
            padding: 0;
            margin-bottom: -10px;
        }

        .titulo p.activi {
            text-align: center;
            font-size: 0.60em;
            padding: 0;
        }

        .titulo_derecha {
            /* position: absolute; */
            top: 47px;
            /* right: -0; */
            float: right;
            width: 180px;
        }

        .titulo_derecha .contenedor_info {
            width: 100%;
            text-align: right;
        }

        .titulo_derecha .contenedor_info p.info {
            font-size: 0.55em;
            margin: 1px;
        }

        .logo {
            width: 80px;
            height: 50px;
            position: absolute;
            top: 47px;
            left: 0;
        }

        .datos_factura {
            width: 100%;
            margin-bottom: 5px;
            margin-top: 3px;
            background: rgb(241, 245, 248);
        }

        .datos_factura tbody td {
            font-size: 0.55em;
        }

        .datos_factura .c1 {
            width: 20%;
        }

        .datos_factura .c2 {
            width: 20%;
        }

        .factura {
            border-collapse: collapse;
            position: relative;
            width: 100%;
            font-size: 0.7em;
        }

        .thead {
            background: rgb(241, 245, 248);
            color: black;
        }

        .thead {
            border-top: solid 1px rgb(216, 216, 216);
            border-bottom: solid 1px rgb(216, 216, 216);
        }

        .factura thead tr th {
            text-align: center;
            font-size: 0.75em;
        }

        .factura tbody tr td {
            font-size: 0.7em;
            text-align: center;
        }

        .factura tbody tr.total td:first-child {
            text-align: right;
            padding-right: 15px;
        }

        .factura tbody tr.total_final td:nth-child(3n),
        .factura tbody tr.total_final td:nth-child(4n),
        .factura tbody tr.total_final td:nth-child(5n),
        tr.total_final td:nth-child(6n) {
            background: rgb(241, 245, 248);
            color: black;
        }

        .total_final td {
            font-size: 0.8em !important;
        }

        .factura tbody tr.total_literal td:nth-child(4n) {
            text-align: right;
            padding-right: 15px;
        }

        .factura tbody tr.total_literal td:nth-child(4n) {
            text-align: left;
            padding-left: 15px;
        }

        .codigos {
            margin-top: 35px;
            width: 70%;
        }

        .codigos tbody tr td {
            font-size: 0.7em;
        }

        .codigos tbody tr td.c1 {
            width: 35%;
        }

        .codigos tbody tr td.c2 {
            width: 65%;
        }

        .codigos tbody tr td.qr {
            width: 30%;
        }

        .qr {
            width: 120px;
            height: 120px;
        }

        .qr img {
            width: 100%;
            height: 100%;
        }

        .info1 {
            margin-top: 20px;
            text-align: center;
            font-weight: bold;
            font-size: 0.6em;
        }

        .info2 {
            text-align: center;
            font-weight: bold;
            font-size: 0.5em;
        }

        .border-top {
            border-top: solid 1px rgb(216, 216, 216);
        }

        .border-bottom {
            border-bottom: solid 1px rgb(216, 216, 216);
        }

        .bold {
            font-weight: bold;
        }

        .derecha {
            text-align: right !important;
        }

        .firma {
            text-align: center;
            padding: 5px;
            font-size: 0.7em;
            width: 50%;
            height: 40px;
            margin: auto;
            margin-top: 15px;
            border: solid 1px rgb(216, 216, 216);
            color: rgb(185, 185, 185);
        }
    </style>
</head>

<body>
    @php
        $empresa = App\Models\Empresa::first();
    @endphp
    <div class="encabezado">
        PROFORMA DE VENTA
    </div>
    <img src="{{ $empresa->logo_b64 }}" class="logo" alt="Logo">
    <div class="titulo_derecha">
        <div class="contenedor_info">
            <p class="info"><strong>PROFORMA N°:
                    {{ $venta->nro_factura }}</strong><span></span></p>
            <p class="info">{{ $empresa->name }} - {{ $empresa->pais }}</p>
            <p class="info">Nit: {{ $empresa->nit }}</p>
            <p class="info">{{ date('d/m/Y', strtotime($venta->fecha_venta)) }}</p>
        </div>
    </div>

    <p style="margin-bottom: 2px; margin-top:67px; font-size:0.7em;" class="bold">Original</p>
    <table class="datos_factura">
        <tbody>
            <tr>
                <td><strong>{{ $venta->cliente->nombre }}</strong></td>
            </tr>
            <tr>
                <td>{{ $empresa->ciudad }}, {{ $empresa->dpto }} ({{ $empresa->pais }})</td>
            </tr>
            <tr>
                <td>Código de Cliente: {{ $venta->cliente->ci }}</td>
            </tr>
            <tr>
                <td>Cel.: {{ $venta->cliente->cel }}</td>
            </tr>
        </tbody>
    </table>

    <table class="factura">
        <tbody>
            <tr>
                <th class="thead">N°</th>
                <th class="thead">Descripción</th>
                <th class="thead">Precio Unitario Bs.</th>
                <th class="thead">Cantidad</th>
                <th class="thead">Descuento Bs.</th>
                <th class="thead">Sub Total Bs.</th>
            </tr>
            <?php
            $cont = 1;
            $total_productos = 0;
            $total_descuentos = 0;
            $descuento = 0;
            ?>
            @foreach ($venta->detalles as $detalle)
                @php
                    if ($detalle->tipo == 'BS') {
                        $descuento = (float) $detalle->descuento * (float) $detalle->cantidad;
                    } else {
                        $descuento = $detalle->costo * ((float) $detalle->descuento / 100) * (float) $detalle->cantidad;
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
            {{-- @for ($i = 1; $i <= 38; $i++)
                <tr>
                    <td>{{ $cont++ }}</td>
                    <td>PRUEBA</td>
                    <td>0.00</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
            @endfor --}}

            <tr class="total_final">
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td class="derecha border-top bold">
                    TOTAL
                </td>
                <td class="bold border-top">{{ $total_productos }}</td>
                <td class="border-top border-bottom bold">
                    &nbsp;
                </td>
                <td class="border-top bold">
                    Bs. {{ $venta->total }}
                </td>
            </tr>
            <tr class="total_final border-top">
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td class="derecha border-top border-bottom bold">
                    TOTAL FINAL
                </td>
                <td class="border-top border-bottom bold">
                    &nbsp;
                </td>
                <td class="border-top border-bottom bold">
                    &nbsp;
                </td>
                <td class="border-top bold border-bottom">
                    Bs. {{ $venta->total_final }}
                </td>
            </tr>
        </tbody>
    </table>

    <div class="firma">
        Firma
    </div>

    {{-- <table class="codigos">
        <tbody>
            <tr>
                <td class="c1">
                    <strong>Código de control:</strong>
                </td>
                <td class="c2">
                    {{ $venta->codigo_control }}
                </td>
            </tr>
        </tbody>
    </table>

    <div class="qr">
        <img src="{{ asset('imgs/ventas/qr/' . $venta->qr) }}" alt="">
    </div>

    <div class="info1">
        "ESTA FACTURA CONTRIBUYE AL DESARROLLO DEL PAÍS EL USO ILÍCITO DE ÉSTA SERA SANCIONADO A LEY"
    </div>
    <div class="info2">
        Ley Nº 453: El proveedor debe exhibir certificaciones de habilitación o documentos que acrediten las capacidades
        u ofertas de servicios.
    </div> --}}
</body>

</html>
