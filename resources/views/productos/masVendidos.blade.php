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

        /* highcharts */
        .chartcontainer {
            width: 790px;
            height: 600px;
            margin: 0 auto;
            background-image: url(../images_x/ajax-loader.gif);
            background-position: center 200px;
            background-repeat: no-repeat;
        }

        .chartcontrol {
            width: 790px;
            text-align: center;
            margin: 10px auto 0px auto;
        }

        .chartcontrol>.chartfields {
            float: left;
            margin: 0px;
            padding: 0px;
        }

        .chartcontrol>.chartfields>p {
            display: inline-block;
        }

        .chartcontrol>.chartbuttons {
            float: right;
            margin: 0px;
            padding: 0px;
        }

        .chartbutton {
            width: 30px;
            height: 30px;
            display: inline-block;
            -webkit-transition: all 300ms;
            -moz-transition: all 300ms;
            -ms-transition: all 300ms;
            -o-transition: all 300ms;
            transition: all 300ms;
        }

        .chartbutton>svg {
            fill: rgb(255, 255, 255);
        }

        .charttypebuttons {
            margin: 0px;
            padding: 0px;
            font-size: 0;
            letter-spacing: 0;
            word-spacing: 0;
            overflow: auto;
            text-align: center;
        }

        .charttypebutton img {
            border-radius: 75px;
            -webkit-transition: background-color 0.5s;
            -moz-transition: background-color 0.5s;
            -ms-transition: background-color 0.5s;
            -o-transition: background-color 0.5s;
            transition: background-color 0.5s;
        }

        .charttypebuttons>.havelock>img {
            background-color: #58aadd;
        }

        .charttypebuttons>.havelock:hover>img {
            background-color: #4f468e;
        }

        .charttypebuttons>.havelockactive>img {
            background-color: #4f468e;
        }

        .charttypebutton .havelockdead>img {
            background-color: #dddddd !important;
        }

        .chartbuttons>.havelock {
            background-color: #58aadd;
        }

        .chartbuttons>.havelock:hover {
            background-color: #4f468e;
        }

        .chartbuttons>.havelockactive {
            background-color: #4f468e;
        }

        .chartbuttons>.havelockdead {
            background-color: #dddddd !important;
        }

        .chartbuttons>.seperator {
            margin-right: 8px;
        }

        .charttypebutton {
            color: #000000;
            display: inline-block;
            padding: 20px;
            margin: 10px;
            vertical-align: top;
            width: 100px;
        }

        .highcharts-drillup-button {
            display: none;
        }

        .highcharts-data-label text {
            font-weight: normal !important;
        }

        .highcharts-drilldown-data-label text {
            text-decoration: none !important;
            font-weight: normal !important;
        }

        .highcharts-xaxis-labels text {
            text-decoration: none !important;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h3 class="titulo_form">PRODUCTOS MAS VENDIDOS</h3>
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
                        <h2 class="titulo_panel">Gráfica</h2>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6 col-md-offset-3">
                                <div class="form-group">
                                    <select name="filtro" id="filtro" class="form-control">
                                        <option value="1">Hasta hoy</option>
                                        <option value="2">Filtrar fecha</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 col-md-offset-3">
                                <div class="form-group">
                                    <input type="date" name="fecha_ini" id="fecha_ini" class="form-control oculto">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="date" name="fecha_fin" id="fecha_fin" class="form-control oculto">
                                </div>
                            </div>
                            <div class="col-md-6 col-md-offset-3">
                                <div class="form-group">
                                    <select name="filtro_vendidos" id="filtro_vendidos" class="form-control">
                                        <option value="mas">Mas vendidos</option>
                                        <option value="menos">Menos vendidos</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-md-offset-3">
                                <div class="form-group">
                                    <label>Cantidad</label>
                                    <input type="number" name="cantidad_filtro" id="cantidad_filtro" value="10"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div id="contenedor_grafico"></div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6 col-md-offset-3">
                                        <label>Ancho gráfico exportación:</label>
                                        <input type="number" id="anchoExportacion" value="1400">
                                    </div>
                                    <div class="col-md-6 col-md-offset-3">
                                        <label>Alto gráfico exportación:</label>
                                        <input type="number" id="altoExportacion" value="700">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <input type="hidden" id="urlEstadisticas" value="{{ route('productos.estadisticas') }}">
@endsection

@section('scripts')
    <script src="{{ asset('js/vistas/productos/masVendidos.js') }}"></script>
@endsection
