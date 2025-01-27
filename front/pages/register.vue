<template>
  <header>
    <title>Triplan</title>
  </header>
  <div class="min-h-screen bg-gray-50 flex items-center justify-center">
    <div class="max-w-md w-full bg-white rounded-lg shadow-lg p-8">
      <h2 class="text-3xl font-bold text-center mb-8">Crear un compte</h2>

      <!--name and surname-->
      <form @submit.prevent="handleRegister" class="space-y-6">
        <div class="flex space-x-4">
          <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700 mb-2">Nom</label>
            <input type="text" v-model="name" required
              class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
              placeholder="Carles">
          </div>

          <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700 mb-2">Cognoms</label>
            <input type="text" v-model="surname" required
              class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
              placeholder="Fernández Marín">
          </div>
        </div>

        <!--gender and birthdate-->
        <div class="flex space-x-4">
          <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700 mb-2">Gènere</label>
            <select name="gender" id="" class="border p-2 rounded ">
              <option value="male">Masculí</option>
              <option value="female">Femení</option>
            </select>
          </div>

          <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700 mb-2">Data de naixement</label>
            <input type="date" v-model="formData.dates"
              class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
          </div>
        </div>

        <!--phone -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Número de telèfon</label>
          <input type="text" v-model="formData.phone" placeholder="+34 655 767 876"
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
            placeholder="elteucorreualternatiu@gmail.com">
        </div>

        <!--password and password confirmation-->
        <div class="flex space-x-4">
          <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700 mb-2">Contrasenya</label>
            <div class="relative">
              <input :type="isPasswordVisible ? 'text' : 'password'" v-model="password" required minlength="8"
              class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
              placeholder="••••••••">
              <button type="button" @click="togglePasswordVisibility('password')" class="absolute right-2 top-1/2 transform -translate-y-1/2">
                <span v-if="isPasswordVisible">👁️</span>
                <span v-else>👁️‍🗨️</span>
              </button>
            </div>
            <p class="mt-1 text-sm text-gray-500">Mínim 8 caràcters</p>
          </div>

          <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700 mb-2">Confirmar contrasenya</label>
            <div class="relative">
              <input :type="isConfirmPasswordVisible ? 'text' : 'password'" v-model="password_confirmation" required
              minlength="8"
              class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
              placeholder="••••••••">
              <button type="button" @click="togglePasswordVisibility('confirmpassword')" class="absolute right-2 top-1/2 transform -translate-y-1/2">
                <span v-if="isConfirmPasswordVisible">👁️</span>
                <span v-else>👁️‍🗨️</span>
              </button>
            </div>
          </div>
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

import { ssrInterpolate } from 'vue/server-renderer';

const user = useState('user');
const surname = ref('');
const name = ref('');
const email = ref('');
const emailalternative = ref('');
const password = ref('');
const password_confirmation = ref('');
const formData = ref({});

const isPasswordVisible = ref(false);
const isConfirmPasswordVisible = ref(false);

const togglePasswordVisibility = (field) => {
  if (field === 'password') {
    isPasswordVisible.value = !isPasswordVisible.value;
  } else if (field === 'confirmpassword') {
    isConfirmPasswordVisible.value = !isConfirmPasswordVisible.value;
  }
};



function handleRegister() {
  user.value = { name: name.value, email: email.value };
  navigateTo('/app');
}
</script>

