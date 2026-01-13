@extends('layouts.admin')

@section('pagina')
    Empresa
@endsection

@section('css')
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3 class="titulo_form">EMPRESA</h3>
            </div>

            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="titulo_panel">INFORMACIÓN ACTUAL</h2>
                        <a href="{{ route('empresa.edit') }}" class="btn btn-warning"><i class="fa fa-edit"
                                data-toggle="tooltip" data-placement="left" title="Modificar"></i> Editar</a>
                    </div>
                    <div class="panel-body">
                        @if (session('bien'))
                            <div class="alert alert-success">
                                <button data-dismiss="alert" class="close">&times;</button>
                                {{ session('bien') }}
                            </div>
                        @endif
                        <table class="data-table table table-bordered table-striped tabla_responsiva">
                            <tbody>
                                <tr>
                                    <td>
                                        <strong>NOMBRE: </strong>
                                        {{ $empresa->name }}
                                    </td>
                                    <td>
                                        <strong>NIT: </strong>
                                        {{ $empresa->nit }}
                                    </td>
                                    <td>
                                        <strong>NRO. AUTORIZACIÓN</strong>
                                        {{ $empresa->nro_aut }}
                                    </td>
                                    <td>
                                        <strong>PAÍS: </strong>
                                        {{ $empresa->pais }}
                                    </td>
                                    <td>
                                        <strong>DPTO.:</strong>
                                        {{ $empresa->dpto }}
                                    </td>
                                    <td>
                                        <strong>CIUDAD: </strong>
                                        {{ $empresa->ciudad }}
                                    </td>
                                    <td>
                                        <strong>ZONA: </strong>
                                        {{ $empresa->zona }}
                                    </td>
                                    <td>
                                        <strong>CALLE: </strong>
                                        {{ $empresa->calle }}
                                    </td>
                                    <td>
                                        <strong>NRO: .</strong>
                                        {{ $empresa->nro }}
                                    </td>
                                    <td>
                                        <strong>E-MAIL</strong>
                                        {{ $empresa->email }}
                                    </td>
                                    <td>
                                        <strong>TELÉFONO: </strong>
                                        {{ $empresa->fono }}
                                    </td>
                                    <td>
                                        <strong>CELULAR: </strong>
                                        {{ $empresa->cel }}
                                    </td>
                                    <td>
                                        <strong>LOGO: </strong>
                                        <img src="{{ asset('imgs/empresa/' . $empresa->logo) }}" alt=""
                                            class="img-table">
                                    </td>
                                    <td>
                                        <strong>ACTIVIDAD ECONOMICA</strong>
                                        {{ $empresa->actividad_eco }}
                                    </td>
                                </tr>
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
@endsection
