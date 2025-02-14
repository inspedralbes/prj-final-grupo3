@extends('layout.index')

@section('content')
<div class="flex flex-col justify-center items-center m-5 gap-5">
    <form action="{{ route('login') }}" method="POST" class="space-y-6 w-full max-w-md bg-white p-8 rounded-xl shadow-lg">
        @csrf
        <p class="text-2xl font-bold text-gray-800 mb-6">Admin | Login</p>
        <div>
            <label for="username" class="block text-lg font-medium text-gray-700">Nom d'usuari</label>
            <input type="text" name="username" id="username" class="p-3 mt-2 border-2 border-gray-300 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="admin" value="{{ old('username') }}">
            @error('username')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="password" class="block text-lg font-medium text-gray-700">Contrasenya</label>
            <input type="password" name="password" id="password" class="p-3 mt-2 border-2 border-gray-300 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="*****">
            @error('password')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="flex justify-end">
            <button type="submit" class="bg-blue-800 text-white py-2 px-6 rounded-full hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Iniciar sessió</button>
        </div>
    </form>
</div>
@endsection