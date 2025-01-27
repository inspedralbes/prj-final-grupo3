<div class="flex flex-col justify-center bg-gray-300 p-6 m-5 rounded-lg shadow-lg relative">
    <p class="text-3xl flex">Registre de paissos</p>
    <button id="close-form" class="absolute top-2 right-4 text-2xl text-red-500 font-bold hover:text-red-700">X</button>
    {{-- <img src="../../icons/red-close-circle-20545.svg" alt="" srcset=""> --}}
    <form action="{{ route('countries.store') }}" method="POST" class="flex gap-4 mt-5">
        @csrf
        <input type="text" name="name" id="name" class="border-2 border-gray-800 rounded-md p-2 shadow-lg" placeholder="Nom país">
        <input type="text" name="code" id="code" class="border-2 border-gray-800 rounded-md p-2 shadow-lg" placeholder="Codi país">
        <button type="submit" id="submit-button" disabled class="ml-auto p-2 px-3 rounded-full bg-blue-400 transition duration-200 hover:bg-blue-700 hover:text-white cursor-pointer">Afegir país</button>
    </form>
</div>

<script>
    document.getElementById('close-form').addEventListener('click', function (e) {
        e.preventDefault();
        const form = document.getElementById('register-form');
        const formButton = document.getElementById('register-button');
        form.classList.add('hidden');
        formButton.classList.remove('hidden');
    });
    function checkForm() {
        const name = document.getElementById('name').value.trim();
        const code = document.getElementById('code').value.trim();
        const submitButton = document.getElementById('submit-button');

        if (name && code) {
            submitButton.disabled = false;
        } else {
            submitButton.disabled = true;
        }
    }
    
    document.getElementById('name').addEventListener('input', checkForm);
    document.getElementById('code').addEventListener('input', checkForm);
    
    checkForm();
</script>