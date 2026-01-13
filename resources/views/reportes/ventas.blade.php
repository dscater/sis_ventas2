@extends('layouts.admin')

@section('pagina')
    Ventas
@endsection

@section('css')
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3 class="titulo_form">REPORTES - VENTAS</h3>
            </div>

            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <form action="{{ route('reportes.ventas_pdf') }}" id="formReporte" method="GET" target="_blank">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-6">
                                            <div class="form-group">
                                                <select name="filtro" id="filtro" class="form-control">
                                                    <option value="todos">Todos</option>
                                                    <option value="empleado">Por empleado</option>
                                                    <option value="cliente">Por cliente</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-6">
                                            <div class="form-group">
                                                <label>Empleado:</label>
                                                <select name="empleado" id="empleado" class="form-control">
                                                    <option value="">Seleccione...</option>
                                                    @foreach ($empleados as $value)
                                                        <option value="{{ $value->id }}">
                                                            @if ($value->empleado)
                                                                {{ $value->empleado->nombre }}
                                                                {{ $value->empleado->paterno }}
                                                                {{ $value->empleado->materno }}
                                                            @else
                                                                {{ $value->name }}
                                                            @endif
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-6">
                                            <div class="form-group">
                                                <label>Cliente:</label>
                                                <select name="cliente" id="cliente" class="form-control">
                                                    <option value="">Seleccione...</option>
                                                    @foreach ($clientes as $value)
                                                        <option value="{{ $value->id }}">{{ $value->nombre }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-3">
                                            <div class="form-group">
                                                <label>Fecha inicial:</label>
                                                <input type="date" name="fecha_ini" value="{{ date('Y-m-d') }}"
                                                    id="fecha_ini" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Fecha final:</label>
                                                <input type="date" name="fecha_fin" value="{{ date('Y-m-d') }}"
                                                    id="fecha_fin" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-6">
                                            <button type="submit" class="btn btn-sm btn-success d-block"
                                                style="width:100%;">
                                                <span>Exportar</span> <i class="fa fa-share"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="text-center">LISTA DE VENTAS</h4>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="gray">
                                            <th width="5%" class="text-center">N°</th>
                                            <th>Empleado</th>
                                            <th>Cliente</th>
                                            <th width="10%">Fecha</th>
                                            <th width="10%">Total Bs.</th>
                                        </tr>
                                    </thead>
                                    <tbody id="contenedor_lista">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        let filtro = $("#filtro");
        let empleado = $("#empleado");
        let cliente = $("#cliente");
        let fecha_ini = $("#fecha_ini");
        let fecha_fin = $("#fecha_fin");

        $(document).ready(function() {
            cambioFiltro();
            cargaDatos();
            filtro.change(function() {
                cambioFiltro();
                cargaDatos();
            });

            filtro.change(cargaDatos);
            empleado.change(cargaDatos);
            cliente.change(cargaDatos);
            fecha_ini.change(cargaDatos);
            fecha_ini.keyup(cargaDatos);
            fecha_fin.change(cargaDatos);
            fecha_fin.keyup(cargaDatos);
        });

        function cambioFiltro() {
            let valor = filtro.val();
            if (valor != 'todos') {
                switch (valor) {
                    case 'empleado':
                        empleado.parents('.form-group').removeClass('oculto')
                        empleado.prop("required", true)

                        cliente.parents('.form-group').addClass('oculto')
                        cliente.removeAttr("required")
                        break;
                    case 'cliente':
                        cliente.parents('.form-group').removeClass('oculto')
                        cliente.prop("required", true)

                        empleado.parents('.form-group').addClass('oculto')
                        empleado.removeAttr("required")
                        break;
                }
            } else {
                empleado.parents('.form-group').addClass('oculto')
                cliente.parents('.form-group').addClass('oculto')
                empleado.removeAttr("required")
                cliente.removeAttr("required")
            }
        }

        function cargaDatos() {
            $.ajax({
                type: "GET",
                url: $("#formReporte").attr("action"),
                data: {
                    filtro: filtro.val(),
                    empleado: empleado.val(),
                    cliente: cliente.val(),
                    fecha_ini: fecha_ini.val(),
                    fecha_fin: fecha_fin.val(),
                },
                dataType: "json",
                success: function(response) {
                    $("#contenedor_lista").html(response)
                }
            });
        }
    </script>
@endsection
