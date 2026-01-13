@extends('layouts.admin')

@section('pagina')
401
@endsection

@section('css')
<link rel="stylesheet" href="{{asset('css/subirFoto.css')}}">
@endsection

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
           <h3 class="titulo_form">No autorizado</h3>
        </div>
        
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="titulo_panel">Sin permiso</h2>
                </div>
                <div class="panel-body">
                    <h3>USTED NO TIENE PERMISO PARA VER ESTA PÁGINA!</h3>
                    <a href="{{route('ventas.index')}}" class="btn btn-primary">Volver</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
@endsection
