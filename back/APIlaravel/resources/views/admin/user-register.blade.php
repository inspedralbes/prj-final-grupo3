<div class="flex flex-col justify-center bg-white p-8 m-6 rounded-lg shadow-2xl relative max-w-lg mx-auto">
    <p class="text-4xl font-semibold text-center text-gray-800 mb-6">Registre d'usuari</p>
    <button id="close-form" class="absolute top-4 right-4 text-2xl text-gray-600 font-bold hover:text-red-600">
        <img src="{{ asset('icons/close_icon.svg') }}" alt="" class="w-8 h-8 duration-300 hover:rotate-180">
    </button>
    @if ($errors->any())
        <div class="bg-red-500 text-white p-4 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form id="user-form" action="{{ route('users.store') }}" method="POST" class="space-y-6">
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
    document.getElementById('close-form').addEventListener('click', function(e) {
        e.preventDefault();
        const form = document.getElementById('register-form');
        const formButton = document.getElementById('register-button');
        form.classList.add('hidden');
        formButton.classList.remove('hidden');
    });

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
