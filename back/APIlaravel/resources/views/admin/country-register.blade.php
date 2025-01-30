<div class="flex flex-col justify-center bg-white m-6 rounded-lg shadow-2xl relative max-w-lg mx-auto">
    <div class="flex flex-row relative bg-gray-800 text-white text-2xl tracking-wider font-bold rounded-t-lg p-4 w-full">
        Registre de països
        <div class="absolute right-4 top-.5">
            <button id="close-form" class="text-2xl text-gray-600 font-bold hover:text-red-600">
                <img src="{{ asset('icons/close_icon.svg') }}" alt="Cerrar"
                    class="w-8 h-8 duration-300 hover:rotate-180">
            </button>
        </div>
    </div>
    <form action="{{ route('countries.store') }}" method="POST" class="space-y-6 p-8">
        @csrf
        <div class="grid grid-cols-1 gap-4">
            <input type="text" name="name" id="name"
                class="p-4 border-2 border-gray-300 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Nom país" required>
            <input type="text" name="code" id="code"
                class="p-4 border-2 border-gray-300 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Codi país" required>
        </div>
        <button type="submit" id="submit-button" disabled
            class="ml-auto w-full p-4 rounded-lg bg-blue-500 text-white text-lg font-semibold transition duration-200 hover:bg-blue-700 disabled:bg-gray-400">Afegir
            país</button>
    </form>
</div>

<script>
    document.getElementById('close-form').addEventListener('click', function(e) {
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
