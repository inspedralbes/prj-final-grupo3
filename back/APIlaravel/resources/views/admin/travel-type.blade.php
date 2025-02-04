@extends('layout.index')

@section('content')
    <div class="flex flex-col justify-center m-5 gap-5 mb-20">
        {{-- <div class="flex justify-end" id="toggle-form">
            <p class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-full cursor-pointer"
                id="register-button">Afegir tipus de viatge</p>
        </div> --}}

        <div id="register-form" class="hidden">
            @include('admin.travel-type-register')
        </div>

        <div class="overflow-x-auto bg-white shadow-md rounded-lg max-w-[1000px] mx-auto">
            <table class="w-full min-w-[70vh] border border-gray-300">
                <thead class="bg-gray-800 text-white text-sm md:text-base">
                    <tr class="text-center">
                        <th class="py-2 px-4 w-[5%]">ID</th>
                        <th class="py-2 px-4 w-[30%] text-left">TIPUS DE VIATGE</th>
                        {{-- <th class="py-2 px-4 w-[10%]">ACCIÓ</th> --}}
                    </tr>
                </thead>
                <tbody class="text-gray-700 bg-gray-100 text-sm md:text-base">
                    @foreach ($travelTypes as $traveltype)
                        <tr class="border-b border-gray-300 text-center">
                            <td class="py-2 px-4 break-words">{{ $traveltype->id }}</td>
                            <td class="py-2 px-4 break-words text-left">{{ $traveltype->type }}</td>
                            {{-- <td class="py-2 px-4">
                                <div class="flex flex-nowrap justify-center gap-2">
                                    <button
                                        class="rounded-full bg-orange-500 px-2 py-1 text-white text-xs md:text-sm hidden md:inline-block"
                                        onclick="editCountry('{{ $country->id }}')">
                                        Modificar
                                    </button>
                                    <button class="rounded-full bg-orange-500 p-2 text-white md:hidden"
                                        onclick="editCountry('{{ $country->id }}')">
                                        <img src="{{ asset('icons/edit.svg') }}" alt="Editar" class="w-5 h-5">
                                    </button>
                                    <button
                                        class="rounded-full bg-red-500 px-2 py-1 text-white text-xs md:text-sm hidden md:inline-block"
                                        onclick="deleteType('{{ $traveltype->id }}')">
                                        Eliminar
                                    </button>
                                    <button class="rounded-full bg-red-500 p-2 text-white md:hidden"
                                        onclick="deleteCountry('{{ $country->id }}')">
                                        <img src="{{ asset('icons/delete.svg') }}" alt="Eliminar" class="w-5 h-5">
                                    </button>
                                </div>
                            </td> --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Función para mostrar el formulario de registro
        document.getElementById('register-button').addEventListener('click', function(e) {
            e.preventDefault();
            const form = document.getElementById('register-form');
            const formButton = document.getElementById('toggle-form');

            // Mostrar el formulario y ocultar el botón
            if (form.classList.contains('hidden')) {
                form.classList.remove('hidden');
                formButton.classList.add('hidden');
            }
        });

        // Función para cerrar el formulario de registro
        document.getElementById('close-form').addEventListener('click', function() {
            const form = document.getElementById('register-form');
            const formButton = document.getElementById('toggle-form');

            // Ocultar el formulario y mostrar el botón
            form.classList.add('hidden');
            formButton.classList.remove('hidden');
        })

        // Función para eliminar un registre
        function deleteType(countryId) {
            console.log('ID de tipus de viatge que vols eliminar:', countryId);
            if (confirm('Estàs segur que vols eliminar aquest tipus de viatge?')) {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                fetch(`/travelType/${countryId}`, {
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
                        alert('Hi ha hagut un error en eliminar el tipus de viatge.');
                    });
            }
        }
    </script>
@endsection
