<!doctype html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TriPlan | Pagina d'administració</title>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <div class="bg-gray-800 text-white py-10 text-center relative">
            <a href="{{ route('users') }}">
                <p class="text-3xl font-bold">PÀGINA D'ADMINISTRACIÓ</p>
                <p class="text-xs">CRUD | TRIPLAN</p>
            </a>
            @if (Auth::check())
                <div class="flex flex-row justify-center gap-4 mt-4">
                    <a href="{{ route('users') }}"
                        class="cursor-pointer text-basefont-medium hover:text-blue-600">Gestió de
                        usuaris</a>
                    <a href="{{ route('countries') }}"
                        class="cursor-pointer text-base font-medium hover:text-blue-600">Gestió de països</a>
                    <a href="{{ route('travel-types') }}"
                        class="cursor-pointer text-base font-medium hover:text-blue-600">Gestió de tipus del viatge</a>
                    <a href="{{ route('movilities') }}"
                        class="cursor-pointer text-base font-medium hover:text-blue-600">Gestió de mobilitats</a>
                    <a href="{{ route('budgets') }}"
                        class="cursor-pointer text-base font-medium hover:text-blue-600">Gestió de pressupost</a>
                    <a href="{{ route('travels') }}"
                        class="cursor-pointer text-base font-medium hover:text-blue-600">Gestió de viatges</a>
                    {{-- <a href="{{ route('publications') }}"
                        class="cursor-pointer text-base font-medium hover:text-blue-600">Gestió de publicacions</a> --}}
                </div>
            @endif
            <div class="absolute top-4 right-4">
                @if (Auth::check())
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        {{-- <button type="submit"
                            class="bg-red-800 text-white py-2 px-6 rounded-full hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">Cerrar
                            sesión</button> --}}
                        <button type="submit"
                            class="bg-gray-500 text-white px-2 pr-3 rounded-full hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 transition-colors">
                            <img src="{{ asset('icons/logout_icon.svg') }}" alt="" class="w-5 h-10"></button>
                    </form>
                @endif
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
