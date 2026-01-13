@extends('layouts.admin')

@section('pagina')
    Modificar cliente
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/subirFoto.css') }}">
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3 class="titulo_form">CLIENTES</h3>
            </div>

            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="titulo_panel">MODIFICAR CLIENTE</h2>
                    </div>
                    <div class="panel-body">
                        <form action="{{ route('clientes.update', $cliente->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="_method" value="PUT">
                            @include('clientes.forms.form')
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-success">Actualizar</button>
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

        //DateMask
        $('[data-mask]').inputmask();
    </script>
@endsection
