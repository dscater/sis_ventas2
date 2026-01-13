<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>SISVENTAS | @yield('pagina')</title>
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('bootstrap-3.3.7/dist/css/bootstrap.css') }}">

    <!-- JQuery DataTable Css -->
    <link href="{{ asset('js/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css') }}" rel="stylesheet">

    {{-- Highcharts --}}
    <link rel="stylesheet"src="{{ asset('Highcharts/code/css/highcharts.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('select2/dist/css/select2.min.css') }}">

    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('css/miEstilo.css') }}">
    @yield('css')
</head>

<body>
    @php
        $empresa = App\Models\Empresa::first();
    @endphp
    <header id="header">
        <div class="logo">
            <img src="{{ asset('imgs/empresa/' . $empresa->logo) }}" alt="logo">
        </div>
        <div class="empresa">
            <h1>{{ $empresa->name }}</h1>
        </div>
        <div class="usuario">
            <div class="icono">
                <img src="{{ asset('imgs/users/' . Auth::user()->foto) }}" alt="Foto">
            </div>
            <div class="nom_usuario">
                @if (Auth::user()->empleado)
                    {{ Auth::user()->empleado->nombre }} {{ Auth::user()->empleado->paterno }}
                    {{ Auth::user()->empleado->materno }}
                @else
                    {{ Auth::user()->name }}
                @endif
            </div>
            <div class="tipo">
                {{ Auth::user()->tipo }}
            </div>
            <div class="estado">
                <span>Activo</span> <i class="fa fa-circle"></i>
            </div>
        </div>
    </header>
    <nav class="navbar navbar-default" id="nav_bar">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!-- <a class="navbar-brand" href="/'.APP_NAME.'/borrowing">PRESTAMOS</a> -->
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    @if (Auth::user()->tipo == 'ADMINISTRADOR')
                        @include('includes.menuAdmin')
                    @endif
                    @if (Auth::user()->tipo == 'EMPLEADO')
                        @include('includes.menuEmpleado')
                    @endif
                </ul>

                <ul class="nav navbar-nav navbar-right">
                    <li data-toggle="tooltip" title="Configurar cuenta"
                        class="{{ request()->is('configurar*') ? 'active' : '' }}" data-placement="bottom">
                        <a href="{{ route('users.config', Auth::user()->id) }}">
                            <i class="fa fa-cog"></i>
                            {{-- <span>SALIR</span> --}}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                            <i class="fa fa-sign-in-alt"></i>
                            <span>SALIR</span>
                        </a>
                    </li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>

    @yield('content')

    <!-- SCRIPTS -->
    <script src="{{ asset('js/jquery-3.2.1.js') }}"></script>
    <script src="{{ asset('bootstrap-3.3.7/dist/js/bootstrap.js') }}"></script>

    <!-- Jquery DataTable Plugin Js -->
    <script src="{{ asset('js/jquery-datatable/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('js/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js') }}"></script>
    <script src="{{ asset('js/jquery-datatable/extensions/export/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('js/jquery-datatable/extensions/export/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('js/jquery-datatable/extensions/export/jszip.min.js') }}"></script>
    <script src="{{ asset('js/jquery-datatable/extensions/export/pdfmake.min.js') }}"></script>
    <script src="{{ asset('js/jquery-datatable/extensions/export/vfs_fonts.js') }}"></script>
    <script src="{{ asset('js/jquery-datatable/extensions/export/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('js/jquery-datatable/extensions/export/buttons.print.min.js') }}"></script>

    <!-- Select2 -->
    <script src="{{ asset('select2/dist/js/select2.full.min.js') }}"></script>

    <!-- Highcharts -->
    <script src="{{ asset('Highcharts/code/highcharts.js') }}"></script>
    <script src="{{ asset('Highcharts/code/modules/data.js') }}"></script>
    <script src="{{ asset('Highcharts/code/modules/exporting.js') }}"></script>
    {{-- <script src="{{asset('Highcharts/code/modules/export-data.js')}}"></script> --}}
    <script src="{{ asset('Highcharts/code/highcharts-3d.js') }}"></script>

    <script>
        Highcharts.setOptions({
            lang: {
                printChart: 'Imprimir',
                downloadJPEG: 'Descargar JPEG',
                downloadPNG: 'Descargar PNG',
                downloadPDF: 'Descargar documento PDF',
                downloadSVG: 'Descargar archivo SVG',
            }
        });

        lenguajeSelect2 = {
            noResults: function() {
                return "No hay resultados";
            },
            searching: function() {
                return "Buscando...";
            }
        }

        $('.select2').select2();

        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
        lenguaje = {
            "decimal": "",
            "emptyTable": "No se encontraron registros",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Registros",
            "infoEmpty": "Mostrando 0 to 0 of 0 Registros",
            "infoFiltered": "(Filtrado de _MAX_ total registros)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Mostrar _MENU_ Registros",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "zeroRecords": "Sin resultados encontrados",
            "paginate": {
                "first": "Primero",
                "last": "Ultimo",
                "next": "Siguiente",
                "previous": "Anterior"
            }
        };

        $('[data-toggle="tooltip"]').tooltip();
    </script>
    @yield('scripts')

</body>

</html>
