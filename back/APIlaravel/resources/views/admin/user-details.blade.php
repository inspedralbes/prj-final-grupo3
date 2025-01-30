@extends('layout.index')

@section('content')
<div class="m-5 gap-5 relative bg-white shadow-2xl rounded-lg p-6 max-w-lg mx-auto">
    <!-- Botón de cierre -->
    <button id="close-form" class="absolute top-4 right-4 text-2xl text-gray-600 font-bold hover:text-red-600">
        <img src="{{ asset('icons/close_icon.svg') }}" alt="" class="w-8 h-8 duration-300 hover:rotate-180">
    </button>
    
    <!-- Imagen basada en el género -->
    <div class="text-center mb-6">
        <img 
            src="{{ $user->gender === 'Female' ? asset('icons/female.svg') : asset('icons/male.svg') }}" 
            alt="Foto del usuario" 
            class="w-40 h-40 rounded-full object-cover mx-auto"
        >
    </div>

    <!-- Datos del usuario en dos columnas -->
    <div class="grid grid-cols-2 gap-4 text-sm text-gray-700">
        <p class="font-medium text-gray-600 text-base">ID:</p>
        <p class="text-gray-800 text-base">{{ $user->id }}</p>

        <p class="font-medium text-gray-600 text-base">Nombre:</p>
        <p class="text-gray-800 text-base">{{ $user->name }}</p>

        <p class="font-medium text-gray-600 text-base">Apellido:</p>
        <p class="text-gray-800 text-base">{{ $user->surname }}</p>

        <p class="font-medium text-gray-600 text-base">Fecha de Nacimiento:</p>
        <p class="text-gray-800 text-base">{{ $user->birth_date }}</p>

        <p class="font-medium text-gray-600 text-base">Género:</p>
        <p class="text-gray-800 text-base">{{ $user->gender }}</p>

        <p class="font-medium text-gray-600 text-base">Teléfono:</p>
        <p class="text-gray-800 text-base">{{ $user->phone_number }}</p>

        <p class="font-medium text-gray-600 text-base">Email:</p>
        <p class="text-gray-800 text-base">{{ $user->email }}</p>

        <p class="font-medium text-gray-600 text-base">Email Alternativo:</p>
        <p class="text-gray-800 text-base">{{ $user->email_alternative ?? 'NaN' }}</p>

        <p class="font-medium text-gray-600 text-base">Fecha de Creación:</p>
        <p class="text-gray-800 text-base">{{ $user->created_at }}</p>

        <p class="font-medium text-gray-600 text-base">Última Actualización:</p>
        <p class="text-gray-800 text-base">{{ $user->updated_at }}</p>
    </div>
</div>

<script>
    document.getElementById('close-form').addEventListener('click', function(e) {
    e.preventDefault();
    window.location.href = '/usuaris'; // Redirige a la ruta '/usuaris'
});
</script>
@endsection