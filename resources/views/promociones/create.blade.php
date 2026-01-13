@extends('layouts.admin')

@section('pagina')
    Nueva promoción
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/subirFoto.css') }}">
    <style>
        .multiselect {
            height: 300px !important;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3 class="titulo_form">PROMOCIONES</h3>
            </div>

            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="titulo_panel">REGISTRAR PROMOCIÓN</h2>
                    </div>
                    <div class="panel-body">
                        <form action="{{ route('promociones.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @include('promociones.forms.form')
                            <div class="row">
                                <div class="col-md-12">
                                    <a href="{{ route('promociones.index') }}" class="btn btn-default"><i
                                            class="fa fa-arrow-left"></i> Volver</a>
                                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i>
                                        Registrar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // SUBIR IMAGEN
        $('body').on('change', '#foto', function(e) {
            addImage(e);
        });

        function addImage(e) {
            var file = e.target.files[0],
                imageType = /image.*/;

            if (!file.type.match(imageType))
                return;

            var reader = new FileReader();
            reader.onload = fileOnload;
            reader.readAsDataURL(file);
        }

        function fileOnload(e) {
            var result = e.target.result;
            $('#imagen_select').attr("src", result);
        }
        // FIN SUBIR IMAGEN
    </script>
@endsection
