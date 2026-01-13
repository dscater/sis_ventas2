@extends('layouts.admin')

@section('css')
    <style type="text/css">
        #imagen {
            width: 120px;
            height: 140px;
        }

        .invalid-feedback {
            color: #F44336;
        }

        .archivos {
            position: relative;
        }

        .archivos input[type="file"] {
            position: absolute;
            top: 0;
            z-index: 100;
            position: absolute;
            opacity: 0;
        }

        .subir {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            padding: 10px;
            background: #f55d3e;
            color: #fff;
            border: 0px solid #fff;
            z-index: 100;
        }

        .subir span {
            margin-left: 5px;
            z-index: 100;
        }

        .subir:hover span {
            cursor: pointer;
        }

        .subir:hover {
            cursor: pointer;
            color: #fff;
            background: #F44336;
        }
    </style>
@endsection

@section('nom_empresa')
    {{ $empresa->name }}
@endsection

@section('pagina')
    Configurar cuenta
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <h3 class="titulo_form">Configurar cuenta</h3>
            </div>

            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="titulo_panel">MODIFICAR INFORMACIÓN</h2>
                    </div>
                    <div class="panel-body">

                        <div class="row">
                            <div class="col-md-12">
                                <h3>MODIFICAR FOTO</h3>
                                @if (session('foto'))
                                    <div class="alert alert-success">
                                        <button data-dismiss="alert" class="close">&times;</button>
                                        {{ session('foto') }}
                                    </div>
                                @endif
                                <form action="{{ route('users.config_update_foto', $user->id) }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="col-md-4 col-md-offset-4 contenedor_foto">
                                        <img src="{{ asset('imgs/users/' . $user->foto) }}" width="150" height="155"
                                            id="imagen_select">
                                        <div class="form-group contenedor_subir">
                                            <input type="file" accept="image/*" style='opacity: 0;' name="foto"
                                                class="file" id="foto">
                                            <label class="subir"for="foto">
                                                <i class="fa fa-image"></i> <span>Elegir foto</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <br>
                                        <button type="submit" class="btn btn-success">Actualizar foto</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <h3>MODIFICAR CONTRASEÑA</h3>
                                @if (session('password'))
                                    <div class="alert alert-success">
                                        <button data-dismiss="alert" class="close">&times;</button>
                                        {{ session('password') }}
                                    </div>
                                @endif
                                <form action="{{ route('users.config_update', $user->id) }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="_method" value="put">
                                    <div class="col-md-12">
                                        <label>Antigua contraseña:</label>
                                        <input type="password" name="oldPassword" id="OldPassword" class="form-control"
                                            required>
                                        @if (session('contra_error') && session('contra_error') == 'old_password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>La contraseña no coincide.</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="col-md-12">
                                        <label>Nueva contraseña:</label>
                                        <input type="password" name="newPassword" id="NewPassword" class="form-control"
                                            required>
                                        @if (session('contra_error') && session('contra_error') == 'comfirm')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>Las contraseñas no coinciden. Intenten nuevamente.</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="col-md-12">
                                        <label>Nueva contraseña (Confirmar)</label>
                                        <input type="password" id="NewPasswordConfirm" name="password_confirm"
                                            class="form-control" required>
                                    </div>
                                    <div class="col-md-12">
                                        <br>
                                        <button type="submit" class="btn btn-success">Actualizar contraseña</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        //EDICION DE IMAGENES
        //Previsualizar la imagen seleccionada
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

        function cambiar() {
            var pdrs = document.getElementById('foto').files[0].name;
            document.getElementById('info').innerHTML = pdrs;
        }
    </script>
@endsection
