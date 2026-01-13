<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SISVENTAS | Iniciar sesión</title>
    <!-- Tell the browser to be responsive to screen width -->
    <link rel="stylesheet" href="{{ asset('bootstrap-3.3.7/dist/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.css') }}">
    <!-- Google Font -->
    <link rel="stylesheet" href="{{ asset('google-fonts/italic.css') }}">
    @yield('css')
</head>

<body class="hold-transition login-page">

    @yield('content')

    <!-- Bootstrap 3.3.7 -->
    <script src="{{ asset('js/jquery-3.2.1.js') }}"></script>
    <script src="{{ asset('bootstrap-3.3.7/dist/js/bootstrap.js') }}"></script>
</body>

</html>
