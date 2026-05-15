<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'InApp') - InApp Inventory Dashboard</title>

    {{-- Favicon --}}
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/images/favicon_io/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/images/favicon_io/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/favicon_io/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('assets/images/favicon_io/site.webmanifest') }}">

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    {{-- Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- Charts --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts/dist/apexcharts.css">

    {{-- Custom CSS --}}
    <link rel="stylesheet" href="{{ asset('css/landing/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth/register.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

    @stack('styles')
</head>

<body>

    <div id="overlay" class="overlay"></div>

    {{-- TOPBAR --}}
    @include('admin.partials.topbar')

    {{-- SIDEBAR --}}
    @include('admin.partials.sidebar')

    {{-- MAIN CONTENT --}}
    <div id="mainContent" class="main-content">
        <div class="content-wrapper">
            @yield('content')
        </div>


    </div>

    {{-- CURSOR (kalau dipakai) --}}
    <div class="cursor-dot" id="cursorDot"></div>
    <div class="cursor-ring" id="cursorRing"></div>

    {{-- JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="{{ asset('js/app.js') }}"></script>

    <script>
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        const topbar = document.getElementById('topbar');
        const overlay = document.getElementById('overlay');

        document.getElementById('toggleBtn')?.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('full');
            topbar.classList.toggle('full');
        });

        document.getElementById('mobileBtn')?.addEventListener('click', () => {
            sidebar.classList.add('mobile-show');
            overlay.classList.add('show');
        });

        overlay?.addEventListener('click', () => {
            sidebar.classList.remove('mobile-show');
            overlay.classList.remove('show');
        });
    </script>

    @stack('scripts')

</body>

</html>