<!DOCTYPE html>
<<<<<<< HEAD
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'InApp') - InApp Inventory Dashboard</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Favicon --}}
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/images/favicon_io/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/images/favicon_io/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/favicon_io/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('assets/images/favicon_io/site.webmanifest') }}">

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Tabler Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

    {{-- ApexCharts --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts/dist/apexcharts.css">

    {{-- Google Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
             --primary: #0a2540;
    --primary-light: rgba(10, 37, 64, 0.08);
            --sidebar-width: 240px;
            --sidebar-collapsed: 70px;
            --topbar-height: 60px;
        }

        * {
            font-family: 'Poppins', sans-serif;
            box-sizing: border-box;
        }

        body {
            background: #f5f5f5;
            overflow-x: hidden;
        }

        /* =====================
           OVERLAY (mobile)
        ===================== */
        .overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .4);
            display: none;
            z-index: 1030;
        }

        .overlay.show {
            display: block;
        }

        /* =====================
           SIDEBAR
        ===================== */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: #fff;
            border-right: 1px solid #eee;
            z-index: 1031;
            transition: width .3s ease;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed);
        }

        /* Logo area */
        .logo-area {
            height: var(--topbar-height);
            display: flex;
            align-items: center;
            padding: 0 20px;
            border-bottom: 1px solid #eee;
            flex-shrink: 0;
            white-space: nowrap;
            overflow: hidden;
        }

        .logo-area a {
            display: flex;
            align-items: center;
            text-decoration: none;
        }

        .logo-area img.logo-icon {
            width: 30px;
            flex-shrink: 0;
        }

        .logo-text {
            margin-left: 10px;
            display: flex;
            align-items: center;
            transition: opacity .2s, width .3s;
            overflow: hidden;
        }

        .sidebar.collapsed .logo-text {
            opacity: 0;
            width: 0;
            margin-left: 0;
        }

        /* Nav list */
        .sidebar .nav-list {
            list-style: none;
            padding: 12px 0;
            margin: 0;
            overflow-y: auto;
            overflow-x: hidden;
            flex: 1;
        }

        /* Section label */
        .sidebar .nav-section {
            padding: 10px 20px 4px;
            white-space: nowrap;
            overflow: hidden;
        }

        .sidebar .nav-section small {
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .8px;
            color: #bbb;
            display: block;
            transition: opacity .2s;
        }

        .sidebar.collapsed .nav-section small {
            opacity: 0;
        }

        /* Nav link */
        .sidebar .nav-link {
            display: flex;
            align-items: center;
            padding: 10px 20px;
            color: #555;
            text-decoration: none;
            font-size: 14px;
            font-weight: 400;
            white-space: nowrap;
            transition: background .2s, color .2s;
            border-right: 3px solid transparent;
            gap: 12px;
        }

        .sidebar .nav-link i {
            font-size: 20px;
            min-width: 24px;
            text-align: center;
            flex-shrink: 0;
            line-height: 1;
        }

        .sidebar .nav-link .nav-text {
            transition: opacity .2s;
            overflow: hidden;
        }

        .sidebar.collapsed .nav-link .nav-text {
            opacity: 0;
            width: 0;
            overflow: hidden;
        }

        .sidebar.collapsed .nav-link {
            padding: 10px;
            justify-content: center;
        }

        .sidebar .nav-link:hover {
            background: var(--primary-light);
            color: var(--primary);
        }

        .sidebar .nav-link.active {
            background: var(--primary-light);
            color: var(--primary);
            border-right-color: var(--primary);
            font-weight: 500;
        }

        .sidebar .nav-link.active i {
            color: var(--primary);
        }

        /* Tooltip for collapsed state */
        .sidebar.collapsed .nav-link {
            position: relative;
        }

        /* =====================
           TOPBAR
        ===================== */
        .topbar {
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            right: 0;
            height: var(--topbar-height);
            background: #fff;
            border-bottom: 1px solid #eee;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            z-index: 1029;
            transition: left .3s ease;
        }

        .topbar.full {
            left: var(--sidebar-collapsed);
        }

        /* Topbar right items */
        .topbar .topbar-right {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-icon {
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            border-radius: 50%;
            background: transparent;
            border: none;
            color: #555;
            font-size: 18px;
            cursor: pointer;
            transition: background .2s, color .2s;
            text-decoration: none;
        }

        .btn-icon:hover {
            background: #f5f5f5;
            color: var(--primary);
        }

        .avatar-sm {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #eee;
        }

        .badge-notif {
            position: absolute;
            top: -3px;
            right: -3px;
            background: #dc3545;
            color: #fff;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        /* =====================
           MAIN CONTENT
        ===================== */
        .main-content {
            margin-left: var(--sidebar-width);
            padding-top: var(--topbar-height);
            min-height: 100vh;
            transition: margin-left .3s ease;
            display: flex;
            flex-direction: column;
        }

        .main-content.full {
            margin-left: var(--sidebar-collapsed);
        }

        .content-wrapper {
            padding: 24px;
            flex: 1;
        }

        /* =====================
           FOOTER
        ===================== */
        footer {
            padding: 14px 24px;
            text-align: center;
            font-size: 12px;
            color: #aaa;
            border-top: 1px solid #eee;
            background: #fff;
        }

        /* =====================
           RESPONSIVE
        ===================== */
        @media (max-width: 992px) {
            .sidebar {
                left: calc(-1 * var(--sidebar-width));
                width: var(--sidebar-width) !important;
                transition: left .3s ease;
            }

            .sidebar.mobile-show {
                left: 0;
            }

            .topbar {
                left: 0 !important;
            }

            .main-content {
                margin-left: 0 !important;
            }

            #toggleBtn {
                display: none !important;
            }
        }
    </style>
=======
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nepertech</title>

    <link rel="stylesheet" href="{{ asset('css/landing/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth/register.css') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
>>>>>>> 2ea55c39820059a9ac9ce1ce4c889bd8ce38a487

    @stack('styles')
</head>

<body>

<<<<<<< HEAD
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

    <footer>
        <p class="mb-0">Copyright &copy; {{ date('Y') }} InApp Inventory Dashboard.</p>
    </footer>
</div>

{{-- JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
    const sidebar     = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');
    const topbar      = document.getElementById('topbar');
    const overlay     = document.getElementById('overlay');

    // Desktop toggle (collapse/expand)
    document.getElementById('toggleBtn')?.addEventListener('click', () => {
        sidebar.classList.toggle('collapsed');
        mainContent.classList.toggle('full');
        topbar.classList.toggle('full');
    });

    // Mobile toggle (show/hide)
    document.getElementById('mobileBtn')?.addEventListener('click', () => {
        sidebar.classList.add('mobile-show');
        overlay.classList.add('show');
    });

    // Close sidebar on overlay click (mobile)
    overlay?.addEventListener('click', () => {
        sidebar.classList.remove('mobile-show');
        overlay.classList.remove('show');
    });
</script>

@stack('scripts')

</body>
=======
    <div class="cursor-dot" id="cursorDot"></div>
    <div class="cursor-ring" id="cursorRing"></div>

    @include('partials.header')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    <script src="{{ asset('js/app.js') }}"></script>

    @stack('scripts')

</body>

>>>>>>> 2ea55c39820059a9ac9ce1ce4c889bd8ce38a487
</html>