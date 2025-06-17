<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? 'Document' }}</title>

    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    @stack('head') <!-- For extra head content, like additional CSS -->
    @stack('styles') <!-- For injected CSS from child views -->

</head>
<body class="bg-light vh-100 vw-100 m-0 p-0">
<x-navbar/>
<main>
    {{ $slot }}  <!-- This is where the content will go -->
</main>

<!-- Bootstrap JS Bundle (including Popper.js) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts') <!-- For extra script content -->
</body>
</html>
