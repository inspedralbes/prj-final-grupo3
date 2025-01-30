@extends('layout.index')

@section('content')
    <div class="flex flex-col justify-center m-5 gap-5 mb-20">
        <!-- Botón para mostrar el formulario de registro -->
        <div class="flex justify-end" id="toggle-form">
            <p
                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-full cursor-pointer" id="register-button">
                Crear un nou usuari
            </p>
        </div>

        <!-- Formulario oculto -->
        <div id="register-form" class="hidden">
            @include('admin.user-register')
        </div>

        <!-- Contenedor de la tabla con scroll horizontal en pantallas pequeñas -->
        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table class="w-full min-w-[600px] border border-gray-300">
                <thead class="bg-gray-800 text-white text-sm md:text-base">
                    <tr class="text-center">
                        <th class="py-2 px-4 w-[5%]">ID</th>
                        <th class="py-2 px-4 text-left w-[20%]">NOM</th>
                        <th class="py-2 px-4 text-left w-[20%]">COGNOM</th>
                        <th class="py-2 px-4">CORREU</th>
                        <th class="py-2 px-4 w-[30%]">ACCIÓ</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 bg-gray-100 text-sm md:text-base">
                    @foreach ($users as $user)
                        <tr class="border-b border-gray-300 text-center">
                            <td class="py-2 px-4">{{ $user->id }}</td>
                            <td class="py-2 px-4 text-left break-words">{{ $user->name }}</td>
                            <td class="py-2 px-4 text-left break-words">{{ $user->surname }}</td>
                            <td class="py-2 px-4 break-words">{{ $user->email }}</td>
                            <td class="py-2 px-4">
                                <div class="flex flex-nowrap justify-center gap-2">
                                    <!-- Botón "Ver más detalles" - Texto (Solo en escritorio) -->
                                    <button
                                        class="rounded-full bg-green-500 px-3 py-1 text-white text-xs md:text-sm hidden md:inline-block"
                                        onclick="showUserDetails('{{ $user->id }}')">
                                        Veure més detalls
                                    </button>
                                    <!-- Botón "Ver más detalles" - Icono (Solo en móvil) -->
                                    <button class="rounded-full bg-green-500 px-1 text-white md:hidden"
                                        onclick="showUserDetails('{{ $user->id }}')">
                                        <img src="{{ asset('icons/details.svg') }}" alt="Ver" class="w-10 h-10">
                                    </button>

                                    <!-- Botón "Modificar" - Texto (Solo en escritorio) -->
                                    <button
                                        class="rounded-full bg-orange-500 px-3 py-1 text-white text-xs md:text-sm hidden md:inline-block"
                                        onclick="editUser('{{ $user->id }}')">
                                        Modificar
                                    </button>
                                    <!-- Botón "Modificar" - Icono (Solo en móvil) -->
                                    <button class="rounded-full bg-orange-500 px-1 text-white md:hidden"
                                        onclick="editUser('{{ $user->id }}')">
                                        <img src="{{ asset('icons/edit.svg') }}" alt="Editar" class="w-10 h-10">
                                    </button>

                                    <!-- Botón "Eliminar" - Texto (Solo en escritorio) -->
                                    <button
                                        class="rounded-full bg-red-500 px-3 py-1 text-white text-xs md:text-sm hidden md:inline-block"
                                        onclick="deleteUser('{{ $user->id }}')">
                                        Eliminar
                                    </button>
                                    <!-- Botón "Eliminar" - Icono (Solo en móvil) -->
                                    <button class="rounded-full bg-red-500 px-1 text-white md:hidden"
                                        onclick="deleteUser('{{ $user->id }}')">
                                        <img src="{{ asset('icons/delete.svg') }}" alt="Eliminar" class="w-10 h-10">
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Función para mostrar el formulario de registro de usuari
        document.getElementById('register-button').addEventListener('click', function(e) {
            e.preventDefault();
            const form = document.getElementById('register-form');
            const formButton = document.getElementById('register-button');

            // Mostrar el formulario y ocultar el botón
            if (form.classList.contains('hidden')) {
                form.classList.remove('hidden');
                formButton.classList.add('hidden');
            }
        });

        // Función para cerrar el formulario de registro de usuari
        document.getElementById('close-register').addEventListener('click', function() {
            const form = document.getElementById('register-form');
            const formButton = document.getElementById('toggle-form');

            // Ocultar el formulario y mostrar el botón
            form.classList.add('hidden');
            formButton.classList.remove('hidden');
        })

        // Función para eliminar un usuario
        function deleteUser(userId) {
            console.log('ID de l\'usuari que vols eliminar:', userId);
            if (confirm('Estàs segur que vols eliminar aquest usuari?')) {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                fetch(`/usuaris/${userId}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert(data.success);
                            location.reload();
                        } else {
                            alert(data.error);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Hi ha hagut un error en eliminar l\'usuari.');
                    });
            }
        };

        function editUser(userId) {
            console.log('ID de l\'usuari que vols editar:', userId);
            window.location.href = `/usuaris/${userId}/edit`;
        }

        function showUserDetails(userId) {
            console.log('ID de l\'usuari que vols veure:', userId);
            window.location.href = `/usuaris/${userId}`;
        }
    </script>
@endsection
