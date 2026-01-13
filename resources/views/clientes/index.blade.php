@extends('layouts.admin')

@section('pagina')
    Clientes
@endsection

@section('css')
    <style>
        .activo {
            font-weight: bold;
            color: green;
        }

        .inactivo {
            font-weight: bold;
            color: red;
        }
    </style>
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3 class="titulo_form">CLIENTES</h3>
            </div>

            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a href="{{ route('clientes.create') }}" class="btn btn-sm btn-success pull-right">
                            <span>Registrar</span> <i class="fa fa-plus"></i>
                        </a>
                        <h2 class="titulo_panel">LISTA DE CLIENTES</h2>
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
                        <table class="data-table table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nº</th>
                                    <th>Nombre</th>
                                    <th>Carnet de identidad</th>
                                    <th>Celular</th>
                                    <th>Estado</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $cont = 1;
                                @endphp
                                @foreach ($clientes as $cliente)
                                    <tr>
                                        <td>{{ $cont++ }}</td>
                                        <td>
                                            {{ $cliente->nombre }}
                                        </td>
                                        <td>
                                            {{ $cliente->ci }} {{ $cliente->ci_exp }}
                                        </td>
                                        <td>
                                            {{ $cliente->cel }}
                                        </td>
                                        <td class="centreado">
                                            @if ($cliente->estado == 1)
                                                <span class="activo">ACTIVO</span>
                                            @else
                                                <span class="inactivo">INACTIVO</span>
                                            @endif
                                        </td>
                                        <td class="btns-opciones">
                                            <a href="{{ route('clientes.edit', $cliente->id) }}" class="modificar"><i
                                                    class="fa fa-edit" data-toggle="tooltip" data-placement="left"
                                                    title="Modificar"></i></a>

                                            @if ($cliente->estado == 1)
                                                <a href="#" data-url="{{ route('clientes.destroy', $cliente->id) }}"
                                                    data-toggle="modal" data-target="#modal-eliminar" class="eliminar"><i
                                                        class="fa fa-minus" data-toggle="tooltip" data-placement="left"
                                                        title="Eliminar / Dar baja"></i></a>
                                            @else
                                                <a href="{{ route('clientes.habilitar', $cliente->id) }}"
                                                    class="ir-evaluacion"><i class="fa fa-check" data-toggle="tooltip"
                                                        data-placement="left" title="Habilitar"></i></a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @include('modal.eliminar')
@endsection

@section('scripts')
    <script>
        //DATA-TABLE
        $('table.data-table').removeAttr('width').DataTable({
            responsive: true,
            columns: [{
                    width: "5%"
                },
                null,
                {
                    width: "12%"
                },
                {
                    width: "12%"
                },
                {
                    width: "12%"
                },
                {
                    width: "12%"
                }
            ],
            scrollX: true,
            scrollY: "400px",
            scrollCollapse: true,
            language: lenguaje,
            pageLength: "50"
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
    </script>
@endsection
