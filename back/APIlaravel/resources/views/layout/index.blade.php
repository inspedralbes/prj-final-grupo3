<!doctype html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TriPlan | Pagina d'administració</title>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .login-container {
            padding: 5vh;
            width: 400px;
        }
    </style>
</head>

<body>
    <div class="min-h-screen">
        <!-- Header -->
        <div class="bg-gray-800 text-white py-10 text-center">
            <p class="text-3xl font-bold">PÀGINA D'ADMINISTRACIÓ</p>
            <p class="text-xs">CRUD | TRIPLAN</p>
            <div class="flex flex-row justify-center gap-4 mt-4">
                <p class="cursor-pointer text-basefont-medium hover:text-blue-600">Gestió de usuaris</p>
                <p class="cursor-pointer text-base font-medium hover:text-blue-600">Gestió de viatges</p>
                <p class="cursor-pointer text-base font-medium hover:text-blue-600">Gestió de publicacions</p>
            </div>
        </div>

        <!-- Login Section -->
        <div class="flex-grow flex items-center justify-center">
            <div class="login-container shadow-lg rounded-lg">
                <p class="text-2xl font-bold text-center mb-4">Login</p>
                <form action="" class="flex flex-col gap-4">
                    <label for="username" class="font-medium">Username</label>
                    <input type="text" name="username" id="username" class="w-full p-2 border rounded-md">
                    <label for="password" class="font-medium">Password</label>
                    <input type="password" name="password" id="password" class="w-full p-2 border rounded-md">
                    <button type="submit" class="border-solid text-black p-2 rounded-md hover:bg-blue-700">
                        Iniciar sesión
                    </button>
                </form>
            </div>
        </div>

        <!-- Content Section -->
        <div class="mt-12 bg-white shadow rounded-lg p-8">
            @yield('content')
        </div>

        <!-- Footer -->
        <footer class="bg-gray-800 text-gray-300 py-4 text-center">
            <p class="text-sm">© 2024 TriPlan. Tots els drets reservats.</p>
        </footer>
    </div>
</body>

</html>