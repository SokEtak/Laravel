<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'App' }}</title>

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css">
    <!-- jQuery UI -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

    <!-- Custom Styles -->
    <style>
        body {
            background: linear-gradient(to right, #221636, #402646);
            color: #f8f9fa;
            max-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        main {
            flex-grow: 1;
            padding: 20px;
        }

        .navbar {
            background: #202233 !important;
            box-shadow: 0 4px 8px rgba(255, 255, 255, 0.1);
        }

        .navbar-nav .nav-link {
            color: #f8f9fa !important;
            transition: color 0.3s ease-in-out;
        }

        .navbar-nav .nav-link:hover {
            color: #ffcc80 !important;
        }

        .dropdown-menu {
            background: #292b44;
            border-radius: 10px;
            padding: 10px;
            box-shadow: 0 4px 8px rgba(255, 255, 255, 0.15);
            opacity: 0;
            transform: translateY(-10px);
            visibility: hidden;
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        .nav-item.dropdown:hover .dropdown-menu {
            opacity: 1;
            transform: translateY(0);
            visibility: visible;
        }

        .dropdown-item {
            color: white;
            display: flex;
            align-items: center;
            transition: background 0.3s ease;
        }

        .dropdown-item:hover {
            background: rgba(255, 204, 128, 0.3);
            color: #ffcc80;
            border-radius: 8px;
        }

        .dropdown-item i {
            margin-right: 10px;
            font-size: 1.2rem;
        }
    </style>
</head>
<body>
    <x-navbar />
    {{--<x-viewTemplate/>--}}
    <main class="container-fluid">
        {{ $slot }}
    </main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
@stack('scripts')

</body>
</html>
