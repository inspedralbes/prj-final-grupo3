@extends('layout.index')

@section('content')
    <div class="flex flex-col justify-center items-center p-4">
        <div class="bg-white shadow-2xl rounded-lg max-w-xl w-full mx-auto">
            <div class="flex flex-row relative bg-gray-800 text-white text-2xl tracking-wider font-bold rounded-t-lg p-4 mb-5 w-full">
                Detalls d'usuari
                <div class="absolute right-4 top-.5">
                    <button id="close-form" class="text-2xl text-gray-600 font-bold hover:text-red-600">
                        <img src="{{ asset('icons/close_icon.svg') }}" alt="Cerrar" class="w-8 h-8 duration-300 hover:rotate-180">
                    </button>
                </div>
            </div>
            <!-- Botón de cierre -->

            <!-- Imagen basada en el género -->
            <div class="text-center mb-6">
                <img src="{{ $user->gender === 'Female' ? asset('icons/female.svg') : asset('icons/male.svg') }}"
                    alt="Foto del usuario" class="w-40 h-40 rounded-full object-cover mx-auto">
            </div>

            <!-- Datos del usuario en dos columnas -->
            <div class="grid grid-cols-2 gap-4 p-6 text-sm text-gray-700 w-full">
                <p class="font-medium text-gray-600 text-base">ID:</p>
                <p class="text-gray-800 text-base break-words">{{ $user->id }}</p>

                <p class="font-medium text-gray-600 text-base">Nombre:</p>
                <p class="text-gray-800 text-base break-words">{{ $user->name }}</p>

                <p class="font-medium text-gray-600 text-base">Apellido:</p>
                <p class="text-gray-800 text-base break-words">{{ $user->surname }}</p>

                <p class="font-medium text-gray-600 text-base">Fecha de Nacimiento:</p>
                <p class="text-gray-800 text-base break-words">{{ $user->birth_date }}</p>

                <p class="font-medium text-gray-600 text-base">Género:</p>
                <p class="text-gray-800 text-base break-words">{{ $user->gender }}</p>

                <p class="font-medium text-gray-600 text-base">Teléfono:</p>
                <p class="text-gray-800 text-base break-words">{{ $user->phone_number }}</p>

                <p class="font-medium text-gray-600 text-base">Email:</p>
                <p class="text-gray-800 text-base break-words">{{ $user->email }}</p>

                <p class="font-medium text-gray-600 text-base">Email Alternativo:</p>
                <p class="text-gray-800 text-base break-words">{{ $user->email_alternative ?? 'NaN' }}</p>

                <p class="font-medium text-gray-600 text-base">Fecha de Creación:</p>
                <p class="text-gray-800 text-base break-words">{{ $user->created_at }}</p>

                <p class="font-medium text-gray-600 text-base">Última Actualización:</p>
                <p class="text-gray-800 text-base break-words">{{ $user->updated_at }}</p>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('close-form').addEventListener('click', function(e) {
            e.preventDefault();
            window.location.href = '/usuaris';
        });
    </script>
@endsection