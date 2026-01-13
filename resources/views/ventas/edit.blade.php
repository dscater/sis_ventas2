@extends('layouts.admin')

@section('pagina')
    Modificar Venta
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/subirFoto.css') }}">
    <style>
        .select {
            padding: 0px !important;
        }

        .select select {
            cursor: pointer;
            border: 0px;
            font-size: 1.1rem;
        }

        .header_detalle {
            background: #3E90FA;
            color: white;
        }

        tr td {
            font-size: 0.89em;
        }

        .total,
        .total:hover {
            background: #3E90FA !important;
            color: white !important;
            font-weight: bold;
            font-size: 1.2em;
        }

        .existe,
        .existe:hover {
            background: #d8fff7 !important;
        }

        #contenedor_registros {
            padding: 10px 20px;
            overflow: auto;
        }


        #contenedor_registros .data-table {
            min-width: 700px;
        }

        #contenedor_registros .data-table tbody {
            display: block;
            max-height: 400px;
            position: relative;
            overflow: auto;
        }


        #contenedor_registros .data-table tbody::-webkit-scrollbar {
            /* Estilos de la barra de desplazamiento en navegadores WebKit (Chrome, Safari, etc.) */
            background-color: #ecececb6;
            width: 8px;
            /* Ancho de la barra de desplazamiento */
        }

        #contenedor_registros .data-table tbody::-webkit-scrollbar-thumb {
            /* Estilos del pulgar de la barra de desplazamiento en navegadores WebKit */
            background-color: #a8a8a8b6;
            /* Color del pulgar */
            border-radius: 4px;
            /* Borde redondeado */
        }

        #contenedor_registros .data-table thead,
        #contenedor_registros .data-table tbody tr {
            display: table;
            width: 100%;
            table-layout: fixed;
        }

        #contenedor_registros .data-table tbody tr td {
            text-align: left;
        }


        #contenedor_registros .data-table thead {
            width: calc(100% - 8px);
        }

        #contenedor_registros .data-table thead tr th:nth-child(1),
        #contenedor_registros .data-table tbody tr td:nth-child(1),
        thead tr th:nth-child(3),
        #contenedor_registros .data-table tbody tr td:nth-child(3),
        thead tr th:nth-child(4),
        #contenedor_registros .data-table tbody tr td:nth-child(4),
        thead tr th:nth-child(5),
        #contenedor_registros .data-table tbody tr td:nth-child(5) {
            width: 10%;
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h3 class="titulo_form">VENTAS</h3>
            </div>

            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="titulo_panel">MODIFICAR VENTA</h2>
                    </div>
                    <div class="panel-body">
                        <form action="{{ route('ventas.update', $venta->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="_method" value="put">
                            @include('ventas.forms.form')
                            <div class="row">
                                <div class="col-md-3">
                                    <a href="{{ url()->previous() }}" class="btn btn-default btn-block"><i
                                            class="fa fa-arrow-left"></i>
                                        <span> Volver</span></a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" name="token" id="token" value="{{ csrf_token() }}">
    <input type="hidden" name="urlRegistraVenta" id="urlRegistraVenta" value="{{ route('ventas.update', $venta->id) }}">
    <input type="hidden" name="urlObtieneDescuento" id="urlObtieneDescuento" value="{{ route('descuentos.info') }}">
    @include('modal.agrega')
@endsection

@section('scripts')
    <script>
        //DATA-TABLE
        // $('table.data-table').removeAttr('width').DataTable({
        //     responsive: true,
        //     columns: [{
        //             width: "5%"
        //         },
        //         null,
        //         {
        //             width: "5%"
        //         },
        //         {
        //             width: "10%"
        //         },
        //         {
        //             width: "5%"
        //         }
        //     ],
        //     scrollX: true,
        //     scrollY: "400px",
        //     scrollCollapse: true,
        //     language: lenguaje,
        //     pageLength: 25
        // });
        var per_page = $("#per_page");
        var search = $("#search");
        var setTimeoutRegistros = null;
        $(document).ready(function() {
            getProductos();

            per_page.change(function() {
                getProductos();
            })

            search.on("keyup", function() {
                $("#contenedor_registros").html("Buscando...")
                clearTimeout(setTimeoutRegistros);
                setTimeoutRegistros = setTimeout(() => {
                    getProductos();
                }, 500)
            })

            $("#contenedor_registros").on("click", ".page-link", function(e) {
                e.preventDefault();
                let url = $(this).attr("href");
                getProductos(url);
            })
        });

        function getProductos(val_url = "") {
            $("#contenedor_registros").html("Cargando...")
            let url = "{{ route('productos.listadoParaVentas') }}" + "?page=1";
            if (val_url != "") {
                url = val_url
            }
            console.log(url);
            $.ajax({
                type: "GET",
                url: url,
                data: {
                    per_page: per_page.val(),
                    search: search.val()
                },
                dataType: "json",
                success: function(response) {
                    setTimeout(() => {
                        $("#contenedor_registros").html(response.html)
                    }, 200);
                }
            });
        }
    </script>
    <script src="{{ asset('js/vistas/ventas/venta.js') }}"></script>
@endsection
