@extends('layout.index')

@section('content')
<div class="flex flex-col justify-center m-5 gap-5 mb-20">
    <div class="flex justify-end" id="register-button">
        <p id="toggle-form" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-full cursor-pointer">Afegir un nou pa&iacute;s</p>
    </div>

    <div id="register-form" class="hidden">
        @include('admin.country-register')
    </div>

    <table class="bg-white border-8 border-black min-w-[90%]">
        <thead class="bg-gray-800 text-white">
            <tr class="text-center">
                <th class="py-2 px-4 w-[5%]">ID</th>
                <th class="py-2 px-4 text-left w-[40%]">NOM</th>
                <th class="py-2 px-4 w-[10%]">CODI</th>
                <th class="py-2 px-4r w-[20%]"> ACCIÓ</th>
            </tr>
        </thead>
        <tbody class="text-gray-700 bg-gray-100">
            @foreach($countries as $country)
            <tr class="border-5 border-gray-200 text-center">
                <td class="py-2 px-4 border-5 border-gray-200">{{ $country->id }}</td>
                <td class="py-2 px-4 text-left">{{ $country->name }}</td>
                <td class="py-2 px-4 border-r-5 border-gray-200">{{ $country->code }}</td>
                <td class="py-2 px-4 flex flex-row justify-center gap-2">
                    <button class="rounded-full bg-blue-800 p-2 text-white cursor-pointer" onclick="editCountry('{{ $country->id }}')">Modificar</button>
                    <button class="rounded-full bg-red-500 p-2 text-white cursor-pointer" onclick="deleteCountry('{{ $country->id }}')">Eliminar</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    // Función para mostrar el formulario de registro de país
    document.getElementById('toggle-form').addEventListener('click', function (e) {
        e.preventDefault();
        const form = document.getElementById('register-form');
        const formButton = document.getElementById('register-button');
        
        // Mostrar el formulario y ocultar el botón
        if (form.classList.contains('hidden')) {
            form.classList.remove('hidden');
            formButton.classList.add('hidden');
        }
    });

    // Función para eliminar un país
    function deleteCountry(countryId) {
        console.log('ID de país que vols eliminar:', countryId);
        if (confirm('Estàs segur que vols eliminar aquest país?')) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            fetch(`/countries/${countryId}`, {
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
                alert('Hi ha hagut un error en eliminar el país.');
            });
        }
    }

    // Función para editar un país
    function editCountry(countryId) {
        console.log('ID de país que vols editar:', countryId);
        window.location.href = `/countries/${countryId}/edit`;
    }

</script>
@endsection