<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8" />
    <title>@yield('title', 'Auth') - InApp Inventory Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/images/favicon_io/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/images/favicon_io/favicon-32x32.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        * { font-family: 'Poppins', sans-serif; }
        body { background-color: #f5f5f5; }
        :root { --bs-primary: #E66239; --bs-primary-rgb: 230,98,57; }
        .btn-primary { background-color: #E66239; border-color: #E66239; }
        .btn-primary:hover { background-color: #c9542f; border-color: #c9542f; }
        .text-primary { color: #E66239 !important; }
        .link-primary { color: #E66239 !important; }
        .form-control:focus, .form-check-input:focus { border-color: #E66239; box-shadow: 0 0 0 .25rem rgba(230,98,57,.25); }
        .form-check-input:checked { background-color: #E66239; border-color: #E66239; }
    </style>
</head>
<body>
    @yield('content')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    (() => {
        'use strict';
        const forms = document.querySelectorAll('.needs-validation');
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    })();
    </script>
</body>
</html>