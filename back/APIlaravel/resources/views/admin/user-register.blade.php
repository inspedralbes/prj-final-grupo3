<div class="flex flex-col justify-center bg-white mt-0 m-6 rounded-lg shadow-2xl relative max-w-lg mx-auto">
    <div class="flex flex-row relative bg-gray-800 text-white text-2xl tracking-wider font-bold rounded-t-lg p-4 w-full">
        Registre d'usuari
        <div class="absolute right-4 top-.5">
            <button id="close-register" class="text-2xl text-gray-600 font-bold hover:text-red-600">
                <img src="{{ asset('icons/close_icon.svg') }}" alt="Cerrar"
                    class="w-8 h-8 duration-300 hover:rotate-180">
            </button>
        </div>
    </div>
    @if ($errors->any())
        <div class="bg-red-500 text-white p-4 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form id="user-form" action="{{ route('users.store') }}" method="POST" class="space-y-6 p-8">
        @csrf
        <div class="grid grid-cols-1 gap-4">
            <input type="text" name="name" id="name"
                class="p-4 border-2 border-gray-300 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Nom" required>
            <input type="text" name="surname" id="surname"
                class="p-4 border-2 border-gray-300 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Cognom" required>
            <input type="date" name="birth_date" id="birth_date"
                class="p-4 border-2 border-gray-300 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-blue-500"
                required>
            <input type="email" name="email" id="email"
                class="p-4 border-2 border-gray-300 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Correu" required>
            <input type="email" name="email_alternative" id="email_alternative"
                class="p-4 border-2 border-gray-300 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Correu alternatiu">
            <input type="password" name="password" id="password"
                class="p-4 border-2 border-gray-300 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Contrasenya" required>
            <input type="tel" name="phone_number" id="phone_number"
                class="p-4 border-2 border-gray-300 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Telèfon" required>
            <select name="gender" id="gender"
                class="h-12 p-2 border-2 border-gray-300 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-blue-500"
                required>
                <option value="" disabled selected>Genere</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
        </div>
        <button type="submit" id="submit-button" disabled
            class="ml-auto w-full p-4 rounded-lg bg-blue-500 text-white text-lg font-semibold transition duration-200 hover:bg-blue-700 disabled:bg-gray-400">Crear
            usuari</button>
    </form>
</div>

<script>

    function checkForm() {
        const name = document.getElementById('name').value.trim();
        const surname = document.getElementById('surname').value.trim();
        const birth_date = document.getElementById('birth_date').value;
        const email = document.getElementById('email').value.trim();
        const email_alternative = document.getElementById('email_alternative').value.trim();
        const password = document.getElementById('password').value.trim();
        const phone_number = document.getElementById('phone_number').value.trim();
        const gender = document.getElementById('gender').value.trim();

        const submitButton = document.getElementById('submit-button');

        if (name && surname && birth_date && email && email_alternative && password && phone_number && gender) {
            submitButton.disabled = false;
        } else {
            submitButton.disabled = true;
        }
    }

    document.getElementById('name').addEventListener('input', checkForm);
    document.getElementById('surname').addEventListener('input', checkForm);
    document.getElementById('birth_date').addEventListener('input', checkForm);
    document.getElementById('email').addEventListener('input', checkForm);
    document.getElementById('email_alternative').addEventListener('input', checkForm);
    document.getElementById('password').addEventListener('input', checkForm);
    document.getElementById('phone_number').addEventListener('input', checkForm);
    document.getElementById('gender').addEventListener('input', checkForm);

    checkForm();
</script>
