<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ninja Network</title>
</head>
<body>
    @if(session('success'))
        <div class="alert alert-success mt-2">
            {{ session('success') }}
        </div>
    @endif
    <header>
        <nav>
            <h1>Ninja Network</h1>
            {{-- <a href={{route("ninjas.index")}}>All Ninja</a>
            <a href={{route("ninjas.create")}}>Create New Ninja</a> --}}
        </nav>
    </header>

    <main class="container">
        {{ $slot }}
    </main>
</body>
</html>