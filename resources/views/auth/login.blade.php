@extends('layouts.login')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
    <div class="content-login">
        <div class="header-login">
            <h1 class="titulo-empresa">{{ $empresa->name }}</h1>
            <img src="{{ asset('imgs/empresa/' . $empresa->logo) }}" class="logo-empresa" alt="Logo">
        </div>
        <div class="body-login">
            <h3 class="titulo-form">INICIAR SESIÓN</h3>
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="input-group col-md-12">
                    {{-- <span class="input-group-addon">
                        <i class="fa fa-user"></i>
                    </span> --}}
                    <input type="text" class="form-control" name="name" autofocus value="{{ old('name') }}"
                        placeholder="Usuario" required>
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    @if ($errors->has('name'))
                        <span class="invalid-feedback" role="alert">
                            <strong class="text-error">{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
                <br>
                <div class="input-group col-md-12">
                    {{-- <span class="input-group-addon">
                        <i class="fa fa-key"></i>
                    </span> --}}
                    <input type="password" class="form-control" name="password" placeholder="Contraseña" required>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                            <strong class="text-error">{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <br>
                <div class="row">
                    <div class="form-group col-md-12" style="display:flex; justify-content: center;">
                        <button type="submit" class="btn btn-default btn-block btn-flat" id="btnAcceder">Acceder</button>
                    </div>
                </div>
                <div class="recuperacion">
                    <a href="{{ route('solicitudes.create') }}">Olvide mi contraseña</a>
                </div>
            </form>
        </div>
    </div>
@endsection
