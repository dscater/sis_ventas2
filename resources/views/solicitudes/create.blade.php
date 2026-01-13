@extends('layouts.login')

@section('css')
<link rel="stylesheet" href="{{asset('css/login.css')}}">
@endsection

@section('content')

<div>
        <div class="header-login">
        <h1 class="titulo-empresa">{{$empresa->name}}</h1>
        <img src="{{asset('imgs/empresa/'.$empresa->logo)}}" class="logo-empresa" alt="Logo">
        </div>
        <div class="body-login">
            <h3 class="titulo-form">RECUPERAR CONTRASEÑA</h3>
            @if(session('bien'))
            <div class="alert alert-success">
                {{session('bien')}}
            </div>
            @endif
            @if(session('noExiste'))
            <div class="alert alert-info">
                {{session('noExiste')}}
            </div>
            @endif
            
            <form action="{{ route('solicitudes.store') }}"" method="POST">
                @csrf
                <div class="input-group col-md-12">
                    {{-- <span class="input-group-addon">
                        <i class="fa fa-user"></i>
                    </span> --}}
                    <input type="number" class="form-control" name="ci" autofocus value="{{ old('ci') }}" placeholder="Carnet de identidad" required>
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <br>
                <div class="input-group col-md-12">
                    {{-- <span class="input-group-addon">
                        <i class="fa fa-key"></i>
                    </span> --}}
                    <textarea class="form-control" style="resize:vertical;" name="motivo" placeholder="Motivo" required></textarea>
                    <span class="glyphicon glyphicon-list-alt form-control-feedback"></span>
                    @if ($errors->has('motivo'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('motivo') }}</strong>
                    </span>
                    @endif
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <a href="{{route('login')}}" class="btn btn-primary pull-left">Volver</a>
                        <button type="submit" class="btn btn-default pull-right">Enviar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
