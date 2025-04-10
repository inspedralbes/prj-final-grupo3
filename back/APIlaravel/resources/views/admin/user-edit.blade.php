@extends('layout.index')

@section('content')
    <div class="flex flex-col justify-center items-center m-5 gap-5">
        <form action="{{ route('users.update', $user->id) }}" method="POST"
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
                    <label for="name" class="block text-lg font-medium text-gray-700">Nom</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                        class="p-3 mt-2 border-2 border-gray-300 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="surname" class="block text-lg font-medium text-gray-700">Cognom</label>
                    <input type="text" name="surname" id="surname" value="{{ old('surname', $user->surname) }}"
                        class="p-3 mt-2 border-2 border-gray-300 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="birth_date" class="block text-lg font-medium text-gray-700">Data de naixement</label>
                    <input type="date" name="birth_date" id="birth_date"
                        value="{{ old('birth_date', $user->birth_date) }}"
                        class="p-3 mt-2 border-2 border-gray-300 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="email" class="block text-lg font-medium text-gray-700">Correu</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                        class="p-3 mt-2 border-2 border-gray-300 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="email_alternative" class="block text-lg font-medium text-gray-700">Correu alternatiu</label>
                    <input type="email" name="email_alternative" id="email_alternative"
                        value="{{ old('email_alternative', $user->email_alternative ?? 'NaN') }}"
                        class="p-3 mt-2 border-2 border-gray-300 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="password" class="block text-lg font-medium text-gray-700">Contrasenya</label>
                    <input type="password" name="password" id="password"
                        class="p-3 mt-2 border-2 border-gray-300 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Introduce una nueva contraseña" autocomplete="new-password">
                </div>
                <div>
                    <label for="phone_number" class="block text-lg font-medium text-gray-700">Telefon</label>
                    <input type="tel" name="phone_number" id="phone_number"
                        value="{{ old('phone_number', $user->phone_number) }}"
                        class="p-3 mt-2 border-2 border-gray-300 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <select name="gender" id="gender"
                    class="h-12 p-2 border-2 border-gray-300 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="" disabled selected>{{ old('gender', $user->gender) }}</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Prefereixo no dir-ho</option>
                </select>

                <div class="flex justify-end">
                    <button type="submit"
                        class="bg-blue-800 text-white py-2 px-6 rounded-full hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Actualizar</button>
                </div>
            </div>
        </form>
    </div>
@endsection
