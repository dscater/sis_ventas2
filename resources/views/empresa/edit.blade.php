@extends('layouts.admin')

@section('pagina')
    Modificar Empresa
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/subirFoto.css') }}">
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3 class="titulo_form">EMPRESA</h3>
            </div>

            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="titulo_panel">MODIFICAR INFORMACIÓN</h2>
                    </div>
                    <div class="panel-body">
                        <form action="{{ route('empresa.update') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="_method" value="put">

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Nombre*:</label>
                                        <input type="text" name="name"
                                            value="{{ isset($empresa) ? $empresa->name : '' }}" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>NIT*:</label>
                                        <input type="text" name="nit" value="{{ isset($empresa) ? $empresa->nit : '' }}"
                                            class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Nro. autorización*:</label>
                                        <input type="text" name="nro_aut"
                                            value="{{ isset($empresa) ? $empresa->nro_aut : '' }}" class="form-control"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label>País*:</label>
                                    <input type="text" name="pais" value="{{ isset($empresa) ? $empresa->pais : '' }}"
                                        class="form-control" required>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Dpto.*:</label>
                                        <input type="text" name="dpto"
                                            value="{{ isset($empresa) ? $empresa->dpto : '' }}" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Ciudad*:</label>
                                        <input type="text" name="ciudad"
                                            value="{{ isset($empresa) ? $empresa->ciudad : '' }}" class="form-control"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Zona*:</label>
                                        <input type="text" name="zona"
                                            value="{{ isset($empresa) ? $empresa->zona : '' }}" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Calle*:</label>
                                        <input type="text" name="calle"
                                            value="{{ isset($empresa) ? $empresa->calle : '' }}" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Nro.*:</label>
                                        <input type="text" name="nro"
                                            value="{{ isset($empresa) ? $empresa->nro : '' }}" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>E-mail*:</label>
                                        <input type="email" name="email"
                                            value="{{ isset($empresa) ? $empresa->email : '' }}" class="form-control"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Teléfono*:</label>
                                        <input type="text" name="fono"
                                            value="{{ isset($empresa) ? $empresa->fono : '' }}" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Celular*:</label>
                                        <input type="text" name="cel"
                                            value="{{ isset($empresa) ? $empresa->cel : '' }}" class="form-control" required>
                                    </div>
                                </div>

                                <div class="col-md-4 col-md-offset-4 contenedor_foto">
                                    <img src="{{ asset('imgs/empresa/' . $empresa->logo) }}" width="150" height="155"
                                        id="imagen_select">
                                    <div class="form-group contenedor_subir">
                                        <input type="file" accept="image/*" style='opacity: 0;' name="foto"
                                            class="file" id="foto">
                                        <label class="subir"for="foto">
                                            <i class="fa fa-image"></i> <span>Elegir foto</span>
                                        </label>
                                    </div>
                                </div>

                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-success btn-block">Actualizar</button>
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
