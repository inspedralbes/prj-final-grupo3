@extends('layout.index')

@section('content')
<div class="flex flex-col justify-center items-center m-5 gap-5">
    <form action="{{ route('countries.update', $country->id) }}" method="POST" class="relative space-y-6 w-full max-w-md bg-white p-8 rounded-xl shadow-lg">
        <button id="close-form" class="absolute top-2 right-4 text-2xl text-gray-600 font-bold hover:text-red-600">X</button>
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Modificar País</h1>
        @csrf
        @method('PUT')
        <div>
            <label for="name" class="block text-lg font-medium text-gray-700">Nombre del País</label>
            <input type="text" name="name" id="name" value="{{ old('name', $country->name) }}" class="p-3 mt-2 border-2 border-gray-300 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        </div>

        <div>
            <label for="code" class="block text-lg font-medium text-gray-700">Código del País</label>
            <input type="text" name="code" id="code" value="{{ old('code', $country->code) }}" class="p-3 mt-2 border-2 border-gray-300 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-blue-800 text-white py-2 px-6 rounded-full hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Actualizar</button>
        </div>
    </form>
</div>
@endsection