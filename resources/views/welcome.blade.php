<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MAESTRANZA</title>
    <link rel="icon" href="{{ asset('images/AdminLTELogo.png') }}">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('css/fontawesome.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styleswelcome.css') }}">
    <style>
        /* Estilos personalizados */
        html, body {
            height: 100%;
        }
        .masthead {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100%;
            text-align: center; /* Centrar texto */
        }
    </style>
</head>
<body class="antialiased bg-secondary">
    <header class="masthead">
        <div class="container">
            <h1 class="">MAESTRANZA</h1>
            <h2 style="margin-left:31%;">Sistema de Gestión de Mantenimiento de Vehículos</h2>
            @if (Route::has('login'))
            <div class="text-center">
                @auth
                <a href="{{ url('/home') }}" class="btn btn-success">Home</a>
                @else
                <a href="{{ route('login') }}" class="btn btn-success btn-lg">Ingresar</a>
                <!-- @if (Route::has('register'))
                <a href="{{ route('register') }}" class="btn btn-info btn-lg">Registrarse</a>
                @endif -->
                @endauth
            </div>
            @endif
        </div>
    </header>
</body>
</html>
