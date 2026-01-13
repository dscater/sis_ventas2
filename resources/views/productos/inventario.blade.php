@extends('layouts.admin')

@section('pagina')
    Venta de productos
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/subirFoto.css') }}">
    <style>
        .select2 {
            height: 34px;
            border-radius: 0px !important;
        }

        .selection {
            height: 34px !important;
            border-radius: 0px !important;
        }

        .select2-selection {
            height: 34px !important;
            display: flex !important;
            vertical-align: middle;
            border-radius: 0px !important;
        }

        .select2-selection__rendered {
            height: 34px !important;
            border-radius: 0px !important;
        }

        #contenedor_filtrados {
            border: solid 1px gray;
            width: 100%;
            overflow: auto;
        }

        .vacio {
            color: gray;
            padding: 9px;
        }

        .fila {
            padding: 9px;
        }

        #contenedor_filtrados .fila:not(:last-child) {
            border-bottom: dotted 2px gray;
            word-wrap: break-word;
        }

        .fila:hover {
            background: rgb(247, 161, 161);
            font-weight: bold;
            cursor: pointer;
        }

        /* TABLA INVENTARIO */
        .tabla_inventario {
            width: 100%;
            border-collapse: collapse;
        }

        .tabla_inventario thead tr th,
        .tabla_inventario tbody tr td {
            padding: 5px;
        }

        .tabla_inventario tbody tr td.centreado {
            text-align: center;
        }

        .precio_total {
            display: flex;
            align-items: center;
        }

        .precio_total {
            margin-bottom: 3px;
        }

        .precio_total label,
        .precio_total input {
            margin: 0px;
            margin-right: 2px;
        }

        #precio_total {
            height: 20px;
            width: 20px;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h3 class="titulo_form">INVENTARIO DE PRODUCTOS</h3>
            </div>
            <input type="hidden" id="fecha_hoy" value="{{ date('Y-m-d') }}">
            <div class="col-md-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="titulo_panel">Filtrar Productos</h2>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="input-group">
                                    <select name="listProductos" id="listProductos" class="form-control select2"
                                        style="height: 34px;">
                                        @foreach ($productos as $value)
                                            <option value="{{ $value->id }}">{{ $value->nom }}</option>
                                        @endforeach
                                    </select>
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary" type="button" id="btnAgregar"
                                            style="border-radius:0px;"><i class="fa fa-plus"></i></button>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-12" style="margin-top:3px;margin-bottom:5px;">
                                <strong>Productos filtrados:</strong>
                                <div id="contenedor_filtrados">
                                    <div class="vacio">No se filtro ningún producto aún</div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button class="btn btn-default" id="btnLimpiar">Limpiar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-10">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="titulo_panel">Lista de Productos</h2>
                        <button class="btn btn-primary" id="btnGeneraPdf"><i class="fa fa-file-pdf"></i> Exportar</button>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12 precio_total">
                                <label for="precio_total">Mostrar Precio Unitario y Total</label>
                                <input type="checkbox" name="precio_total" id="precio_total">
                            </div>
                            <div class="col-md-12" id="contenedor_tabla"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <input type="hidden" id="urlGetInventario" value="{{ route('productos.getInventario') }}">
    <input type="hidden" id="urlGetInventarioPdf" value="{{ route('productos.getInventarioPdf') }}">
@endsection

@section('scripts')
    <script>
        let listProductos = $('#listProductos');
        let filtro_vendidos = $('#filtro_vendidos');
        let cantidad_filtro = $("#cantidad_filtro");
        let filtro_productos = [];
        let datos = [];
        let datos_copia = [];
        let btnLimpiar = $("#btnLimpiar");

        let fila = `<div class="fila" data-id="0"></div>`;
        let btnAgregar = $("#btnAgregar");
        let contenedor_filtrados = $("#contenedor_filtrados");
        let anchoExportacion = $("#anchoExportacion").val();
        let altoExportacion = $("#altoExportacion").val();
        let contenedor_tabla = $("#contenedor_tabla");
        let muestra_precio_total = "no";

        $(document).ready(function() {
            reiniciaFechas();
            cargaDatos();
            $('#filtro').change(function() {
                let filtro = $(this).val();
                if (filtro != 1) {
                    $('#fecha_ini').removeClass('oculto');
                    $('#fecha_fin').removeClass('oculto');
                    cargaDatos();
                } else {
                    $('#fecha_ini').addClass('oculto');
                    $('#fecha_fin').addClass('oculto');
                    reiniciaFechas();
                    cargaDatos();
                }
            });

            $("#precio_total").change(function() {
                muestra_precio_total = "no";
                if ($(this).prop("checked")) {
                    muestra_precio_total = "si";
                }
                cargaDatos();
            });

            $('#fecha_ini').change(cargaDatos);
            // $('#fecha_ini').keyup(cargaDatos);

            $('#fecha_fin').change(cargaDatos);
            // $('#fecha_fin').keyup(cargaDatos);

            filtro_vendidos.change(cargaDatos);

            cantidad_filtro.on("keyup change", cargaDatos);

            btnLimpiar.click(function() {
                filtro_productos = [];
                contenedor_filtrados.html(`<div class="vacio">No se filtro ningún producto aún</div>`);
                cargaDatos();
            });


            btnAgregar.click(function() {
                if (listProductos.val() != "") {
                    // comprobar existencia del array
                    if (!filtro_productos.includes(listProductos.val())) {
                        // existe vacio
                        if (contenedor_filtrados.children(".vacio").length > 0) {
                            contenedor_filtrados.html("");
                        }
                        let nueva_fila = $(fila).clone();
                        nueva_fila.attr("data-id", listProductos.val());
                        nueva_fila.html(listProductos.children("option:selected").text());
                        filtro_productos.push(listProductos.val());
                        contenedor_filtrados.append(nueva_fila);
                        cargaDatos();
                    }
                }
            });

            contenedor_filtrados.on("click", ".fila", function() {
                let id = $(this).attr("data-id");
                console.log(id);
                let index = filtro_productos.indexOf(id);
                console.log(index);
                if (index > -1) {
                    filtro_productos.splice(index, 1);
                    $(this).remove();
                    if (contenedor_filtrados.children(".fila").length == 0) {
                        contenedor_filtrados.html(
                            `<div class="vacio">No se filtro ningún producto aún</div>`);
                    }
                    cargaDatos();
                }
            });

            $("#btnGeneraPdf").click(function() {
                $.ajax({
                    type: "POST",
                    url: $('#urlGetInventarioPdf').val(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    xhrFields: {
                        responseType: 'blob'
                    },
                    data: {
                        filtro: $('#filtro').val(),
                        fecha_ini: $('#fecha_ini').val(),
                        fecha_fin: $('#fecha_fin').val(),
                        filtro_vendidos: filtro_vendidos.val(),
                        cantidad_filtro: cantidad_filtro.val(),
                        filtro_productos: filtro_productos,
                        precio_total: muestra_precio_total
                    },
                    success: function(response) {
                        let pdfBlob = new Blob([response], {
                            type: "application/pdf",
                        });
                        let urlReporte = URL.createObjectURL(pdfBlob);
                        window.open(urlReporte);
                    }
                });
            });
        });

        function reiniciaFechas() {
            $('#fecha_ini').val($('#fecha_hoy').val());
            $('#fecha_fin').val($('#fecha_hoy').val());
        }

        var hoy = new Date();
        var fecha_actual = ("0" + hoy.getDate()).slice(-2) + "-" + ("0" + (hoy.getMonth() + 1)).slice(-2) + "-" + hoy
            .getFullYear();

        function cargaDatos() {
            $.ajax({
                type: "GET",
                url: $('#urlGetInventario').val(),
                data: {
                    filtro: $('#filtro').val(),
                    fecha_ini: $('#fecha_ini').val(),
                    fecha_fin: $('#fecha_fin').val(),
                    filtro_vendidos: filtro_vendidos.val(),
                    cantidad_filtro: cantidad_filtro.val(),
                    filtro_productos: filtro_productos,
                    precio_total: muestra_precio_total
                },
                dataType: "json",
                success: function(response) {
                    contenedor_tabla.html(response);
                }
            });
        }
    </script>
@endsection
