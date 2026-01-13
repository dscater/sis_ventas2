@extends('layouts.admin')

@section('pagina')
    Productos
@endsection

@section('css')
    <style>
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
        #contenedor_registros .data-table tbody tr td:nth-child(1) {
            width: 5%;
        }
    </style>
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3 class="titulo_form">PRODUCTOS</h3>
            </div>

            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a href="{{ route('productos.create') }}" class="btn btn-sm btn-success pull-right">
                            <span>Nuevo producto</span> <i class="fa fa-plus"></i>
                        </a>
                        <h2 class="titulo_panel">LISTA DE PRODUCTOS</h2>
                    </div>
                    <div class="panel-body">
                        @if (session('bien'))
                            <div class="alert alert-success">
                                <button data-dismiss="alert" class="close">&times;</button>
                                {{ session('bien') }}
                            </div>
                        @endif
                        @if (session('uso'))
                            <div class="alert alert-info">
                                <button data-dismiss="alert" class="close">&times;</button>
                                {{ session('uso') }}
                            </div>
                        @endif

                        @if (session('noActualizable'))
                            <div class="alert alert-warning">
                                <button data-dismiss="alert" class="close">&times;</button>
                                {{ session('noActualizable') }}
                            </div>
                        @endif
                        @if (session('bienIngreso'))
                            <div class="alert alert-success">
                                <button data-dismiss="alert" class="close">&times;</button>
                                {{ session('bienIngreso') }}
                            </div>
                        @endif

                        <div class="row" style="margin-bottom:15px;">
                            <div class="col-md-4">
                                <select name="" id="per_page" class="form-control">
                                    <option value="5">5 registros</option>
                                    <option value="10">10 registros</option>
                                    <option value="20">20 registros</option>
                                    <option value="50" selected>50 registros</option>
                                    <option value="100">100 registros</option>
                                    <option value="200">200 registros</option>
                                </select>
                            </div>
                            <div class="col-md-6 col-md-offset-2">
                                <input type="text" class="form-control" placeholder="Buscar" id="search">
                            </div>
                        </div>
                        <div id="contenedor_registros" class="row text-center">
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @include('modal.eliminar')
    @include('modal.ingreso')
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
        //             width: "10%"
        //         },
        //         {
        //             width: "10%"
        //         },
        //         {
        //             width: "10%"
        //         },
        //         {
        //             width: "10%"
        //         },
        //         null,
        //         {
        //             width: "15%"
        //         }
        //     ],
        //     scrollX: true,
        //     scrollY: "400px",
        //     scrollCollapse: true,
        //     language: lenguaje,
        //     pageLength: "50"
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

        // ELIMINAR
        $(document).on('click', 'table.data-table tbody tr td.btns-opciones a.eliminar', function(e) {
            e.preventDefault();
            let registro = $(this).parents('tr').children('td').eq(1).text();
            $('#mensajeEliminar').html(`¿Está seguro(a) de eliminar el registro <b>${registro}</b>?`);
            let url = $(this).attr('data-url');
            $('#formEliminar').prop('action', url);
        });

        $('#btnEliminar').click(function() {
            $('#formEliminar').submit();
        });

        // ELIMINAR
        $(document).on('click', 'table.data-table tbody tr td.btns-opciones a.ingreso', function(e) {
            e.preventDefault();
            let registro = $(this).parents('tr').children('td').eq(1).text();
            $('#nomProducto').html(`Registrar ingresos del producto <b>${registro}</b>`);
            let url = $(this).attr('data-url');
            $('#formRegistraIngreso').prop('action', url);
        });

        $('#btnRegistraIngreso').click(function() {
            //validar
            let cantidad = $('#cantidadIngreso').val();
            if (cantidad != '' && cantidad != null) {
                $('#errorVacio').addClass('oculto');
                if (cantidad > 0) {
                    $('#errorCero').addClass('oculto');
                    $('#formRegistraIngreso').submit();
                } else {
                    $('#errorCero').removeClass('oculto');
                }
            } else {
                $('#errorVacio').removeClass('oculto');
            }
        });

        function getProductos(val_url = "") {
            $("#contenedor_registros").html("Cargando...")
            let url = "{{ route('productos.index') }}" + "?page=1";
            if (val_url != "") {
                url = val_url
            }
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
@endsection
