<template>
  <div class="min-h-screen bg-gray-50 flex items-center justify-center">
    <div class="max-w-md w-full bg-white rounded-lg shadow-lg p-8">
      <h2 class="text-3xl font-bold text-center mb-8">Crear un compte</h2>

      <form @submit.prevent="handleRegister" class="space-y-6">
        <!-- <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Nom</label>
          <input type="text" v-model="registerAuth.name.value" required
            class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
            placeholder="Carles">
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Cognom</label>
          <input type="text" v-model="registerAuth.surname.value" required
            class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
            placeholder="Fernández">
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Data de naixement</label>
          <input type="date" v-model="registerAuth.formData.dates"
            class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Correu</label>
          <input type="email" v-model="registerAuth.email.value" required
            class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
            placeholder="elteucorreu@gmail.com">
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Correu alternatiu</label>
          <input type="email" v-model="registerAuth.emailalternative.value" required
            class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
            placeholder="elteucorreu@gmail.com">
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Contrasenya</label>
          <input type="password" v-model="registerAuth.password.value" required minlength="8"
            class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
            placeholder="••••••••">
          <p class="mt-1 text-sm text-gray-500">Mínim 8 caràcters</p>
        </div> -->

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

import { useRegisterAuth } from '~/composable/useRegisterAuth';

const registerAuth = useRegisterAuth();

// Register manager
const handleRegister = async () => {
  const userData = {
    name: "Jhon",
    surname: "Doe",
    email: "jhon@example.com",
    email_alternative: "jhonalternativ@example.com",
    password: "password123",
    password_confirmation: "password123",
    birth_date: "1990-02-11",
    phone_number: "123456789",
    gender: "male"
  };
  // const userData = {
  //   name : registerAuth.name.value,
  //   surname: registerAuth.surname.value,
  //   email: registerAuth.email.value,
  //   emailalternative: registerAuth.emailalternative.value,
  //   password: registerAuth.password.value,
  //   password_confirmation: registerAuth.password.value,
  //   birth_date: registerAuth.formData.dates,
  //   phone_number: "123456789",
  //   gender: "male",
  // };

  console.log(userData);

  await registerAuth.registerUser(userData);
};
</script>