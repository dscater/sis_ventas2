@extends('layouts.admin')

@section('pagina')
    Usuarios
@endsection

@section('css')
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3 class="titulo_form">USUARIOS</h3>
            </div>

            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a href="{{ route('users.create') }}" class="btn btn-sm btn-success pull-right">
                            <span>Nuevo registro</span> <i class="fa fa-plus"></i>
                        </a>
                        <h2 class="titulo_panel">LISTA DE USUARIOS</h2>
                    </div>
                    <div class="panel-body">
                        @if (session('bien'))
                            <div class="alert alert-success">
                                <button data-dismiss="alert" class="close">&times;</button>
                                {{ session('bien') }}
                            </div>
                        @endif
                        <table class="data-table table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nº</th>
                                    <th>Usuario</th>
                                    <th>Nombre</th>
                                    <th>CI</th>
                                    <th>Celular / Teléfono</th>
                                    <th>Foto</th>
                                    <th>Rol</th>
                                    <th>Tipo</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $cont = 1;
                                @endphp
                                @foreach ($empleados as $empleado)
                                    <tr>
                                        <td>{{ $cont++ }}</td>
                                        <td>
                                            {{ $empleado->usuario }}
                                        </td>
                                        <td>
                                            {{ $empleado->nombre }} {{ $empleado->paterno }} {{ $empleado->materno }}
                                        </td>
                                        <td>
                                            {{ $empleado->ci }} {{ $empleado->ci_exp }}
                                        </td>
                                        <td>
                                            {{ $empleado->cel }} / {{ $empleado->fono ?: 'SN' }}
                                        </td>
                                        <td>
                                            <img src="{{ asset('imgs/empleado/' . $empleado->foto) }}" alt=""
                                                class="img-table">
                                        </td>
                                        <td>
                                            {{ $empleado->rol }}
                                        </td>
                                        <td>
                                            {{ $empleado->tipo }}
                                        </td>
                                        <td class="btns-opciones">
                                            <a href="{{ route('users.edit', $empleado->id) }}" class="modificar"><i
                                                    class="fa fa-edit" data-toggle="tooltip" data-placement="left"
                                                    title="Modificar"></i></a>

                                            <a href="{{ route('users.informacionEmpleado', $empleado->id) }}"
                                                target="_blank" class="evaluar"><i class="fa fa-eye" data-toggle="tooltip"
                                                    data-placement="left" title="Información"></i></a>

                                            <a href="#" data-url="{{ route('users.destroy', $empleado->id) }}"
                                                data-toggle="modal" data-target="#modal-eliminar" class="eliminar"><i
                                                    class="fa fa-trash" data-toggle="tooltip" data-placement="left"
                                                    title="Eliminar"></i></a>
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
                {
                    width: "10%"
                },
                null,
                {
                    width: "10%"
                },
                {
                    width: "14%"
                },
                {
                    width: "8%"
                },
                {
                    width: "10%"
                },
                {
                    width: "10%"
                },
                {
                    width: "15%"
                }
            ],
            scrollX: true,
            scrollY: "400px",
            scrollCollapse: true,
            language: lenguaje,
            pageLength: 50
        });

        // ELIMINAR
        $(document).on('click', 'table.data-table tbody tr td.btns-opciones a.eliminar', function(e) {
            e.preventDefault();
            let usuario = $(this).parents('tr').children('td').eq(2).text();
            $('#mensajeEliminar').html(`¿Está seguro(a) de eliminar al usuario <b>${usuario}</b>?`);
            let url = $(this).attr('data-url');
            $('#formEliminar').prop('action', url);
        });

        $('#btnEliminar').click(function() {
            $('#formEliminar').submit();
        });
    </script>
@endsection
