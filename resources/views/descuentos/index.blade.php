@extends('layouts.admin')

@section('pagina')
    Descuentos
@endsection

@section('css')
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3 class="titulo_form">DESCUENTOS</h3>
            </div>

            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a href="{{ route('descuentos.create') }}" class="btn btn-sm btn-success pull-right">
                            <span>Nuevo descuento</span> <i class="fa fa-plus"></i>
                        </a>
                        <h2 class="titulo_panel">LISTA DE DESCUENTOS</h2>
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
                                    <th>Descuento</th>
                                    <th>Tipo</th>
                                    <th>Descripción</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $cont = 1;
                                @endphp
                                @foreach ($descuentos as $descuento)
                                    <tr>
                                        <td>{{ $cont++ }}</td>
                                        <td>
                                            {{ $descuento->nom }}
                                        </td>
                                        <td>
                                            {{ $descuento->descuento }}
                                        </td>
                                        <td>
                                            {{ $descuento->txt_tipo }}
                                        </td>
                                        <td>
                                            {{ $descuento->descripcion }}
                                        </td>
                                        <td class="btns-opciones">
                                            <a href="{{ route('descuentos.edit', $descuento->id) }}" class="modificar"><i
                                                    class="fa fa-edit" data-toggle="tooltip" data-placement="left"
                                                    title="Modificar"></i></a>

                                            <a href="#" data-url="{{ route('descuentos.destroy', $descuento->id) }}"
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
                null,
                null,
                null,
                null,
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
