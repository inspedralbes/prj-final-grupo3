<!doctype html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TriPlan | Pagina d'administració</title>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <div class="bg-gray-800 text-white py-10 text-center">
            <a href="{{ route('home') }}">
                <p class="text-3xl font-bold">PÀGINA D'ADMINISTRACIÓ</p>
                <p class="text-xs">CRUD | TRIPLAN</p>
            </a>
            <div class="flex flex-row justify-center gap-4 mt-4">
                <a href="{{ route('users') }}" class="cursor-pointer text-basefont-medium hover:text-blue-600">Gestió de usuaris</a>
                <a href="{{ route('countries') }}" class="cursor-pointer text-base font-medium hover:text-blue-600">Gestió de paissos</a>
                <a href="{{ route('countries') }}" class="cursor-pointer text-base font-medium hover:text-blue-600">Gestió de viatges</a>
                <a href="{{ route('countries') }}" class="cursor-pointer text-base font-medium hover:text-blue-600">Gestió de publicacions</a>
            </div>
        </div>

        <!-- Content Section -->
        <div class="flex-grow bg-gray-100">
            @yield('content')
        </div>

        <!-- Footer -->
        <footer class="bg-gray-800 text-gray-300 py-4 text-center">
            <p class="text-sm">© 2024 TriPlan. Tots els drets reservats.</p>
        </footer>
    </div>
</body>

</html>