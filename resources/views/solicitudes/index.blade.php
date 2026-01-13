@extends('layouts.admin')

@section('pagina')
    Solitud de contraseñas
@endsection

@section('css')
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3 class="titulo_form">SOLICITUD DE CONTRASEÑAS</h3>
            </div>

            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="titulo_panel">LISTA DE SOLITUDES</h2>
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
                                    <th>Empleado</th>
                                    <th>Razón / Motivo</th>
                                    <th>Estado</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $cont = 1;
                                @endphp
                                @foreach ($solicitudes as $solicitud)
                                    <tr>
                                        <td>{{ $cont++ }}</td>
                                        <td>
                                            {{ $solicitud->user->empleado->nombre }}
                                            {{ $solicitud->user->empleado->paterno }}
                                            {{ $solicitud->user->empleado->materno }}
                                        </td>
                                        <td>
                                            {{ $solicitud->motivo }}
                                        </td>
                                        <td>
                                            {{ $solicitud->estado }}
                                        </td>
                                        <td class="btns-opciones">
                                            @if ($solicitud->estado == 'PENDIENTE')
                                                <a href="#"
                                                    data-url="{{ route('solicitudes.asignar', $solicitud->id) }}"
                                                    data-toggle="modal" data-target="#modal-asignar"
                                                    class="asignar ir-evaluacion"><i class="fa fa-key" data-toggle="tooltip"
                                                        data-placement="left" title="Asignar contraseña"></i></a>
                                            @endif

                                            {{-- <a href="#" data-url="{{route('solicitudes.destroy',$solicitud->id)}}" data-toggle="modal" data-target="#modal-eliminar" class="eliminar"><i class="fa fa-trash" data-toggle="tooltip" data-placement="left" title="Eliminar"></i></a> --}}
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
    @include('modal.contrasena')
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
                null,
                null,
                {
                    width: "8%"
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


        // ASIGNAR CONTRASEÑA
        $(document).on('click', 'table.data-table tbody tr td.btns-opciones a.asignar', function(e) {
            e.preventDefault();
            let registro = $(this).parents('tr').children('td').eq(1).text();
            $('#nombreEmpleado').html(`${registro}`);
            let url = $(this).attr('data-url');
            $('#formAsignar').prop('action', url);
        });

        $('#btnAsignar').click(function() {
            let contra = $('#new_password').val();
            if (contra != null && contra != '') {
                $('#error_contrasena').addClass('oculto');
                $('#formAsignar').submit();
            } else {
                $('#error_contrasena').removeClass('oculto');
            }
        });
    </script>
@endsection
