<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Temas de Curso')</title>

    {{-- Toastr CSS (desde CDN) --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    
    
    {{-- Carga los assets de Vite (incluyendo bootstrap.css que importaste) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @yield('css')

    {{-- Favicon --}}
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
</head>
<body class="bg-light">
    {{-- Loading spinner --}}
    <div id="loading-spinner" class="d-none position-fixed top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 d-flex justify-content-center align-items-center" style="z-index: 9999;">
        <div class="d-flex flex-column align-items-center text-white">
            <div class="spinner-border text-info mb-3" style="width: 4rem; height: 4rem; border-width: 0.3em;" role="status">
                <span class="visually-hidden">Cargando...</span>
            </div>
            
        </div>
    </div>

    <div id="app">
        

        <main class="py-4">
            <div class="container">
                @yield('content')
            </div>
        </main>
    </div>

    {{-- jQuery (requerido por Toastr, desde CDN) --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    {{-- Toastr JS (desde CDN) --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script> {{-- Spanish locale --}}

    {{-- Script para manejar las notificaciones flash de la sesión --}}
    <script>
        // Configuración global para Toastr
        toastr.options = {
            "closeButton": false,
            "progressBar": false,
            "positionClass": "toast-top-center",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        // Mostrar toasts basados en la sesión de Laravel
        @if(Session::has('success'))
            toastr.success("{{ Session::get('success') }}", "¡Éxito!");
        @endif

        @if(Session::has('error'))
            toastr.error("{{ Session::get('error') }}", "Error");
        @endif
        
        @if(Session::has('info'))
            toastr.info("{{ Session::get('info') }}", "Información");
        @endif

        @if(Session::has('warning'))
            toastr.warning("{{ Session::get('warning') }}", "Advertencia");
        @endif

        // Mostrar errores de validación como toast
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                toastr.error("{{ $error }}", "Error de validación");
            @endforeach
        @endif

        // Funciones para el spinner
        window.showLoader = function() {
            document.getElementById('loading-spinner').classList.remove('d-none');
        };

        window.hideLoader = function() {
            document.getElementById('loading-spinner').classList.add('d-none');
        };
    </script>
    
    {{-- Aquí se pueden añadir scripts específicos de cada página --}}
    @stack('scripts')
</body>
</html>