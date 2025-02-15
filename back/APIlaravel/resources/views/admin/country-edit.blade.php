@extends('layout.index')

@section('content')
    <div class="flex flex-col justify-center items-center m-5 gap-5">
        <form action="{{ route('countries.update', $country->id) }}" method="POST"
            class="w-full max-w-md bg-white rounded-xl shadow-lg">
            <div
                class="flex flex-row relative bg-gray-800 text-white text-2xl tracking-wider font-bold rounded-t-lg p-4 w-full">
                Modificar dades d'usuari
                <div class="absolute right-4 top-.5">
                    <button id="close-form" class="text-2xl text-gray-600 font-bold hover:text-red-600">
                        <img src="{{ asset('icons/close_icon.svg') }}" alt="Cerrar"
                            class="w-8 h-8 duration-300 hover:rotate-180">
                    </button>
                </div>
            </div>
            @csrf
            @method('PUT')
            <div class="pt-6 p-8 space-y-6 ">
                <div>
                    <label for="name" class="block text-lg font-medium text-gray-700">Nombre del País</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $country->name) }}"
                        class="p-3 mt-2 border-2 border-gray-300 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                </div>

                <div>
                    <label for="code" class="block text-lg font-medium text-gray-700">Código del País</label>
                    <input type="text" name="code" id="code" value="{{ old('code', $country->code) }}"
                        class="p-3 mt-2 border-2 border-gray-300 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                        class="bg-blue-800 text-white py-2 px-6 rounded-full hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Actualizar</button>
                </div>
            </div>
        </form>
    </div>
@endsection
