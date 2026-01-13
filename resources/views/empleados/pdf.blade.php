<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Empleado</title>
    <style>
        * {
            font-family: sans-serif;
        }

        @page {
            margin-top: 1.5cm;
            margin-left: 2cm;
            margin-bottom: 1.5cm;
            margin-right: 1.5cm;
        }

        footer {
            background-color: rgb(255, 243, 212);
            position: absolute;
            text-align: right;
            bottom: 0;
            width: 100%;
            height: 40px;
        }

        .logo {}

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table thead tr th {
            text-align: center;
            font-size: 0.85em;
        }

        table thead tbody td {
            font-size: 0.75em;
        }

        .titulo1 {
            margin-top: -20px;
            width: 100%;
            font-size: 1.1em;
            text-align: center;
        }

        .titulo2 {
            width: 100%;
            font-size: 0.9em;
            text-align: center;
        }

        .centro {
            text-align: center;
        }

        .izquierda {
            text-align: left;
            padding-left: 5px;
        }

        .derecha {
            text-align: right;
            padding-right: 5px;
        }

        .bold {
            font-weight: bold;
        }

        .infoEmpleado {
            width: 80%;
            margin: auto;
            font-size: 0.85em;
            border-collapse: separate;
            border-spacing: 10px;
        }

        .infoNota {
            width: 60%;
            margin: auto;
        }

        .titulo3 {
            text-align: center;
            text-decoration: underline;
            margin-bottom: 5px;
        }

        .infoNota thead tr th {
            font-size: 0.9em;
            background: rgba(219, 219, 219, 1);
            padding: 3px;
        }

        .infoNota tbody tr td {
            font-size: 0.75em;
            padding: 3px;
        }

        .grande {
            font-size: 1.1em;
        }

        .plomo {
            background: rgba(219, 219, 219, 1);
        }

        .izquierda {
            font-weight: bold;
            width: 85px;
            padding-bottom: 0px;
        }

        .td_foto {
            width: 140px;
            padding-top: 0px !important;
            position: relative;
            vertical-align: top;
        }

        .foto {
            width: 140px;
            height: 140px;
        }

        .td_info {
            padding-right: 10px;
            padding-left: 10px;
            border-bottom: dotted 1px gray;
        }
    </style>
</head>

<body>
    <img src={{ $empresa->logo_b64 }}" alt="Logo" class="logo" style="width:120px;height:60px;">
    <h1 class="titulo1">{{ $empresa->name }}</h1>
    <h2 class="titulo2">INFORMACIÓN DE EMPLEADO</h2>

    <table class="infoEmpleado">
        <tbody>
            <tr>
                <td class="izquierda">Nombre:</td>
                <td class="td_info">{{ $empleado->nombre }} {{ $empleado->paterno }} {{ $empleado->materno }}</td>
                <td class="td_foto" rowspan="6" colspan="2"><img src="{{ $empleado->foto_b64 }}" alt="Foto"
                        class="foto"></td>
            </tr>
            <tr>
                <td class="izquierda">C.I.:</td>
                <td class="td_info">{{ $empleado->ci }} {{ $empleado->ci_exp }}</td>
            </tr>
            <tr>
                <td class="izquierda">Celular/Teléfono:</td>
                <td class="td_info">{{ $empleado->cel }} {{ $empleado->fono ?: 'S/N' }}</td>
            </tr>
            <tr>
                <td class="izquierda">Correo:</td>
                <td class="td_info">{{ $empleado->correo }}</td>
            </tr>
            <tr>
                <td class="izquierda">Dirección:</td>
                <td class="td_info">{{ $empleado->dir }}</td>
            </tr>
            <tr>
                <td class="izquierda">Rol:</td>
                <td class="td_info">{{ $empleado->rol }}</td>
            </tr>
        </tbody>
    </table>
</body>

</html>
