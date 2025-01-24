<template>
  <header>
    <title>Triplan</title>
  </header>
  <div class="min-h-screen bg-gray-50 flex items-center justify-center">
    <div class="max-w-md w-full bg-white rounded-lg shadow-lg p-8">
      <h2 class="text-3xl font-bold text-center mb-8">Crear un compte</h2>

      <!--name-->
      <form @submit.prevent="handleRegister" class="space-y-6">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Nom</label>
          <input type="text" v-model="name" required
            class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
            placeholder="Carles">
        </div>

        <!--surname-->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Cognom</label>
          <input type="text" v-model="surname" required
            class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
            placeholder="Fernández">
        </div>

        <!--gender-->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Gènere</label>
          <select name="gender" id="" class="border p-2 rounded">
            <option value="male">Masculí</option>
            <option value="female">Femení</option>
          </select>
        </div>

        <!--birthdate-->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Data de naixement</label>
          <input type="date" v-model="formData.dates"
            class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
        </div>

        <!--phone-->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Número de telèfon</label>
          <input type="text" v-model="formData.phone" placeholder="Número de telèfon"
            class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
        </div>

        <!--mail-->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Correu</label>
          <input type="email" v-model="email" required
            class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
            placeholder="elteucorreu@gmail.com">
        </div>

        <!--mailalternative-->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Correu alternatiu</label>
          <input type="email" v-model="emailalternative" required
            class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
            placeholder="elteucorreu@gmail.com">
        </div>

        <!--type-->
        <div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Amb qui viatges?</label>
            <select v-model="selectedType" name="type" id="" class="border p-2 rounded">
              <option value="alone">Sol</option>
              <option value="friends">Amics</option>
              <option value="family">Família</option>
              <option value="partner">Parella</option>
            </select>
          </div>
          <!-- if selectedtype is friends or family -->
          <div v-if="selectedType === 'friends' || selectedType === 'family'" class="mt-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Quantitat de persones:</label>
            <input type="number" v-model="numberOfPeople" min="1" class="border p-2 rounded w-full"
              placeholder="Introdueix el nombre de persones" />
          </div>
        </div>

        <!--password-->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Contrasenya</label>
          <input type="password" v-model="password" required minlength="8"
            class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
            placeholder="••••••••">
          <p class="mt-1 text-sm text-gray-500">Mínim 8 caràcters</p>
        </div>

        <div>
          <label for="" class="block text-sm font-medium text-gray-700">Confirmar Contrasenya</label>
          <input type="password" v-model="formData.password_confirmation" required minlength="8"
            class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
            placeholder="••••••••">
          <p class="mt-1 text-sm text-gray-500">Mínim 8 caràcters</p>
        </div>

        <button type="submit"
          class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 transition duration-200">
          Crear un compte
        </button>
      </form>

      <p class="mt-6 text-center text-gray-600">
        Ja tens un compte?
        <NuxtLink to="/login" class="text-blue-600 hover:text-blue-800 font-medium">
          Inicia sessió aquí
        </NuxtLink>
      </p>

      <NuxtLink to="/" class="block mt-4 text-center text-gray-500 hover:text-gray-700">
        Tornar a inici
      </NuxtLink>
    </div>
  </div>
</template>

<script setup>

const user = useState('user');
const surname = ref('');
const name = ref('');
const email = ref('');
const password = ref('');
const emailalternative = ref('');
const formData = ref({});
const selectedType = ref('alone');
const persons = ref(null);


const handleRegister = () => {
  // Here you would typically make an API call to create a new user
  // For demo purposes, we'll just simulate a successful registration
  user.value = { name: name.value, email: email.value };
  navigateTo('/app');
};
</script>