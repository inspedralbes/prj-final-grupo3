<div class="flex flex-col justify-center bg-white mt-0 m-6 rounded-lg shadow-2xl relative max-w-lg mx-auto">
    <div class="flex flex-row relative bg-gray-800 text-white text-2xl tracking-wider font-bold rounded-t-lg p-4 w-full">
        TriPlan | Viatge
        <div class="absolute right-4 top-.5">
            <button id="close-form" class="text-2xl text-gray-600 font-bold hover:text-red-600">
                <img src="{{ asset('icons/close_icon.svg') }}" alt="Cerrar"
                    class="w-8 h-8 duration-300 hover:rotate-180">
            </button>
        </div>
    </div>



    <form id="travel-form" action="{{ route('travels.store') }}" method="POST" class="space-y-6 p-8">
        @csrf
        <div class="grid grid-cols-1 gap-4">
            {{-- Error --}}
            @if ($errors->any())
                <div class="bg-red-500 text-white p-4 rounded mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Usuario -->
            <div class="flex flex-col gap-2">
                <label for="id_user">Nom usuari</label>
                <select name="id_user" id="id_user"
                    class="h-12 p-2 border-2 border-gray-300 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required>
                    <option value="" disabled selected>Selecciona un usuari</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} {{ $user->surname }}</option>
                    @endforeach
                </select>
            </div>

            <!-- País -->
            <div class="flex flex-col gap-2">
                <label for="id_user">Nom país</label>
                <select name="id_country" id="id_country"
                    class="h-12 p-2 border-2 border-gray-300 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required>
                    <option value="" disabled selected>Selecciona un país</option>
                    @foreach ($countries as $country)
                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Tipo de Viaje -->
            <div class="flex flex-col gap-2">
                <label for="id_user">Tipus de viatge</label>
                <select name="id_type" id="id_type"
                    class="h-12 p-2 border-2 border-gray-300 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required>
                    <option value="" disabled selected>Selecciona el tipus de viatge</option>
                    @foreach ($types as $type)
                        <option value="{{ $type->id }}">{{ strtoupper($type->type) }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Presupuesto -->
            {{-- <label for="id_user">Nom usuari</label> --}}
            {{-- <select name="id_budget" id="id_budget"
                class="h-12 p-2 border-2 border-gray-300 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-blue-500"
                required>
                <option value="" disabled selected>Selecciona el presupuesto</option>
                @foreach ($budgets as $budget)
                    <option value="{{ $budget->id }}" data-min="{{ $budget->min_budget }}"
                        data-max="{{ $budget->max_budget }}" data-final="{{ $budget->final_price }}">
                        {{ $budget->id }}
                    </option>
                @endforeach
            </select> --}}

            <div class="flex flex-col gap-1">
                <label for="id_user">Pressupost</label>
                <div class="flex gap-3">
                    <input type="text" name="id_budget_min" id="id_budget_min"
                        class="p-3 mt-2 border-2 border-gray-300 rounded-lg w-full" placeholder="Pressupost mínim">
                    <input type="text" name="id_budget_max" id="id_budget_max"
                        class="p-3 mt-2 border-2 border-gray-300 rounded-lg w-full" placeholder="Pressupost màxim">
                    {{-- <input type="text" name="id_budget_final" id="id_budget_final"
                        class="p-3 mt-2 border-2 border-gray-300 rounded-lg w-full" placeholder="Preu final"> --}}
                </div>
            </div>

            <!-- Movilidad -->
            <div class="flex flex-col gap-2">
                <label for="id_user">Mobilitat</label>
                <select name="id_movility" id="id_movility"
                    class="h-12 p-2 border-2 border-gray-300 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required>
                    <option value="" disabled selected>Selecciona la mobilitat</option>
                    @foreach ($movilities as $movility)
                        <option value="{{ $movility->id }}">{{ strtoupper($movility->type) }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Fechas -->
            <div class="flex flex-col gap-2">
                <label for="id_user">Data inici - Data final</label>
                <div class="flex gap-3">
                    <input type="date" name="date_init" id="date_init"
                        class="p-4 border-2 border-gray-300 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                    <input type="date" name="date_end" id="date_end"
                        class="p-4 border-2 border-gray-300 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                </div>
            </div>

            <!-- Descripción -->
            <div class="flex flex-col gap-2">
                <label for="id_user">Descripció</label>
                <textarea name="description" id="description" rows="4"
                    class="p-4 border-2 border-gray-300 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Descripció del viatge" required></textarea>
            </div>
        </div>
        <button type="submit" id="submit-button" disabled
            class="ml-auto w-full p-4 rounded-lg bg-blue-500 text-white text-lg font-semibold transition duration-200 hover:bg-blue-700 disabled:bg-gray-400">Crear viatge</button>
    </form>
</div>

<script>
    function checkForm() {
        const id_user = document.getElementById('id_user').value;
        const id_country = document.getElementById('id_country').value;
        const id_type = document.getElementById('id_type').value;
        const id_budget_min = document.getElementById('id_budget_min').value;
        const id_budget_max = document.getElementById('id_budget_max').value;
        // const id_budget_final = document.getElementById('id_budget_final').value;
        const id_movility = document.getElementById('id_movility').value;
        const date_init = document.getElementById('date_init').value;
        const date_end = document.getElementById('date_end').value;
        const description = document.getElementById('description').value.trim();

        const submitButton = document.getElementById('submit-button');

        if (id_user && id_country && id_type && id_budget_min && id_budget_max && id_movility &&
            date_init && date_end && description) {
            submitButton.disabled = false;
        } else {
            submitButton.disabled = true;
        }
    }

    document.getElementById('id_user').addEventListener('input', checkForm);
    document.getElementById('id_country').addEventListener('input', checkForm);
    document.getElementById('id_type').addEventListener('input', checkForm);
    document.getElementById('id_budget_min').addEventListener('input', checkForm);
    document.getElementById('id_budget_max').addEventListener('input', checkForm);
    // document.getElementById('id_budget_final').addEventListener('input', checkForm);
    document.getElementById('id_movility').addEventListener('input', checkForm);
    document.getElementById('date_init').addEventListener('input', checkForm);
    document.getElementById('date_end').addEventListener('input', checkForm);
    document.getElementById('description').addEventListener('input', checkForm);

    // document.getElementById('id_budget').addEventListener('change', function() {
    //     // Obtener el elemento seleccionado
    //     const selectedOption = this.options[this.selectedIndex];

    //     // Obtener los valores de los atributos data- de la opción seleccionada
    //     const minPrice = selectedOption.getAttribute('data-min');
    //     const maxPrice = selectedOption.getAttribute('data-max');
    //     const finalPrice = selectedOption.getAttribute('data-final');

    //     // Asignar los valores a los campos correspondientes
    //     document.getElementById('id_budget_min').value = minPrice;
    //     document.getElementById('id_budget_max').value = maxPrice;
    //     document.getElementById('id_budget_final').value = finalPrice;
    // });

    checkForm();
</script>
