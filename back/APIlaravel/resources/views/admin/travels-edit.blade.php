@extends('layout.index')

@section('content')
    <div class="flex flex-col justify-center items-center m-5 gap-5">
        <form action="{{ route('travels.update', $travel->id) }}" method="POST"
            class="w-full max-w-md bg-white rounded-xl shadow-lg">
            <div
                class="flex flex-row relative bg-gray-800 text-white text-2xl tracking-wider font-bold rounded-t-lg p-4 w-full">
                Modificar Dades del Viatge
                <div class="absolute right-4 top-.5">
                    <button id="close-form" class="text-2xl text-gray-600 font-bold hover:text-red-600">
                        <img src="{{ asset('icons/close_icon.svg') }}" alt="Cerrar"
                            class="w-8 h-8 duration-300 hover:rotate-180">
                    </button>
                </div>
            </div>
            @csrf
            @method('PUT')
            <div class="pt-6 p-8 space-y-6">
                @if ($errors->any())
                    <div class="bg-red-500 text-white p-4 rounded mb-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div>
                    <label for="id_user" class="block text-lg font-medium text-gray-700">Usuari</label>
                    <select name="id_user" id="id_user" class="p-3 mt-2 border-2 border-gray-300 rounded-lg w-full"
                        required>
                        <option value="" disabled>Selecciona un usuari</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ $travel->id_user == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} {{ $user->surname }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="id_country" class="block text-lg font-medium text-gray-700">País</label>
                    <select name="id_country" id="id_country" class="p-3 mt-2 border-2 border-gray-300 rounded-lg w-full"
                        required>
                        <option value="" disabled>Selecciona un país</option>
                        @foreach ($countries as $country)
                            <option value="{{ $country->id }}" {{ $travel->id_country == $country->id ? 'selected' : '' }}>
                                {{ $country->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="id_type" class="block text-lg font-medium text-gray-700">Tipus de viatge</label>
                    <select name="id_type" id="id_type" class="p-3 mt-2 border-2 border-gray-300 rounded-lg w-full"
                        required>
                        <option value="" disabled>Selecciona un tipus de viatge</option>
                        @foreach ($types as $type)
                            <option value="{{ $type->id }}" {{ $travel->id_type == $type->id ? 'selected' : '' }}>
                                {{ strtoupper($type->type) }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="id_budget" class="block text-lg font-medium text-gray-700">Pressupost (€)</label>
                    <div class="flex gap-3">
                        <input type="text" name="id_budget_min" id="id_budget_min"
                            class="p-3 mt-2 border-2 border-gray-300 rounded-lg w-full"
                            value="{{ $travel->budget->min_budget }} ">
                        <input type="text" name="id_budget_max" id="id_budget_max"
                            class="p-3 mt-2 border-2 border-gray-300 rounded-lg w-full"
                            value="{{ $travel->budget->max_budget }} ">
                        {{-- <input type="text" name="id_budget_final" id="id_budget_final"
                            class="p-3 mt-2 border-2 border-gray-300 rounded-lg w-full"
                            value="{{ $travel->budget->final_price }} "> --}}
                    </div>
                    {{-- <select name="id_budget" id="id_budget" class="p-3 mt-2 border-2 border-gray-300 rounded-lg w-full"
                        required>
                        <option value="" disabled>Selecciona un presupuesto</option>
                        @foreach ($budgets as $budget)
                            <option value="{{ $budget->id }}" {{ $travel->id_budget == $budget->id ? 'selected' : '' }}>
                                {{ $budget->min_budget }} - {{ $budget->max_budget }}</option>
                        @endforeach
                    </select> --}}
                </div>

                <div>
                    <label for="id_movility" class="block text-lg font-medium text-gray-700">Mobilitat</label>
                    <select name="id_movility" id="id_movility" class="p-3 mt-2 border-2 border-gray-300 rounded-lg w-full"
                        required>
                        <option value="" disabled>Selecciona una mobilitat</option>
                        @foreach ($movilities as $movility)
                            <option value="{{ $movility->id }}"
                                {{ $travel->id_movility == $movility->id ? 'selected' : '' }}>
                                {{ strtoupper($movility->type) }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="date_init" class="block text-lg font-medium text-gray-700">Data inici</label>
                    <input type="date" name="date_init" id="date_init"
                        value="{{ old('date_init', $travel->date_init) }}"
                        class="p-3 mt-2 border-2 border-gray-300 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                </div>

                <div>
                    <label for="date_end" class="block text-lg font-medium text-gray-700">Data final</label>
                    <input type="date" name="date_end" id="date_end" value="{{ old('date_end', $travel->date_end) }}"
                        class="p-3 mt-2 border-2 border-gray-300 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                </div>

                <div>
                    <label for="description" class="block text-lg font-medium text-gray-700">Descripció</label>
                    <textarea name="description" id="description"
                        class="p-3 mt-2 border-2 border-gray-300 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>{{ old('description', $travel->description) }}</textarea>
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                        class="bg-blue-800 text-white py-2 px-6 rounded-full hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Actualitzar
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
