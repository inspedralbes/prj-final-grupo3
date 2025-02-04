@extends('layout.index')

@section('content')
    <div class="flex flex-col justify-center m-5 gap-5 mb-20">
        <!-- Botón para mostrar el formulario de registro -->
        <div class="flex justify-end" id="toggle-form">
            <p class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-full cursor-pointer"
                id="register-button">
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
                        <th class="py-2 px-4 text-left">ID COUNTRY</th>
                        <th class="py-2 px-4 text-left">ID TYPE</th>
                        <th class="py-2 px-4 text-left">ID BUDGET</th>
                        <th class="py-2 px-4 text-left">ID MOVILITY</th>
                        <th class="py-2 px-4 text-left">QUANTITAT DE DIES</th>
                        <th class="py-2 px-4 text-left">DATA INICIAL</th>
                        <th class="py-2 px-4 text-left">DATA FINAL</th>
                        <th class="py-2 px-4 text-left">DESCRIPCIÓ</th>
                        <th class="py-2 px-4 w-[30%]">ACCIÓ</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 bg-gray-100 text-sm md:text-base">
                    @foreach ($travels as $travel)
                        <tr class="border-b border-gray-300 text-center">
                            <td class="py-2 px-4">{{ $travel->id }}</td>
                            <th class="py-2 px-4 text-left">{{ $travel->id_country }}</th>
                            <th class="py-2 px-4 text-left">{{ $travel->id_type }}</th>
                            <th class="py-2 px-4 text-left">{{ $travel->id_budget }}</th>
                            <th class="py-2 px-4 text-left">{{ $travel->id_movility }}</th>
                            <th class="py-2 px-4 text-left">{{ $travel->qunt_date }}</th>
                            <th class="py-2 px-4 text-left">{{ $travel->date_init }}</th>
                            <th class="py-2 px-4 text-left">{{ $travel->date_end }}</th>
                            <th class="py-2 px-4 text-left">{{ $travel->description }}</th>
                            <td class="py-2 px-4">
                                <div class="flex flex-nowrap justify-center gap-2">
                                    <!-- Botón "Ver más detalles" - Texto (Solo en escritorio) -->
                                    <button
                                        class="rounded-full bg-green-500 px-3 py-1 text-white text-xs md:text-sm hidden md:inline-block"
                                        {{-- onclick="showUserDetails('{{ $user->id }}')" --}}
                                        >
                                        Veure més detalls
                                    </button>
                                    <!-- Botón "Ver más detalles" - Icono (Solo en móvil) -->
                                    <button class="rounded-full bg-green-500 px-1 text-white md:hidden"
                                        {{-- onclick="showUserDetails('{{ $user->id }}')" --}}
                                        >
                                        <img src="{{ asset('icons/details.svg') }}" alt="Ver" class="w-10 h-10">
                                    </button>

                                    <!-- Botón "Modificar" - Texto (Solo en escritorio) -->
                                    <button
                                        class="rounded-full bg-orange-500 px-3 py-1 text-white text-xs md:text-sm hidden md:inline-block"
                                        {{-- onclick="editUser('{{ $user->id }}')" --}}
                                        >
                                        Modificar
                                    </button>
                                    <!-- Botón "Modificar" - Icono (Solo en móvil) -->
                                    <button class="rounded-full bg-orange-500 px-1 text-white md:hidden"
                                        {{-- onclick="editUser('{{ $user->id }}')" --}}
                                        >
                                        <img src="{{ asset('icons/edit.svg') }}" alt="Editar" class="w-10 h-10">
                                    </button>

                                    <!-- Botón "Eliminar" - Texto (Solo en escritorio) -->
                                    <button
                                        class="rounded-full bg-red-500 px-3 py-1 text-white text-xs md:text-sm hidden md:inline-block"
                                        {{-- onclick="deleteUser('{{ $user->id }}')" --}}
                                        >
                                        Eliminar
                                    </button>
                                    <!-- Botón "Eliminar" - Icono (Solo en móvil) -->
                                    <button class="rounded-full bg-red-500 px-1 text-white md:hidden"
                                        {{-- onclick="deleteUser('{{ $user->id }}')" --}}
                                        >
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
@endsection
