<template>
  <div class="min-h-screen bg-gray-50 flex flex-col items-center justify-center text-center">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-lg p-12">
      <h1 class="text-5xl font-bold text-blue-600 mb-6">Benvingut a Triplan!</h1>
      <p class="text-xl text-gray-600 mb-8">El teu viatge comença aquí. Planifica el teu viatge perfecte amb nosaltres!
      </p>

      <div class="space-y-4">
        <button @click="handlePlanTrip"
          class="px-8 py-4 bg-blue-600 text-white text-lg rounded-lg hover:bg-blue-700 transition duration-200">
          Fes clic aquí per planificar el teu viatge! </button>

        <div v-if="!user" class="pt-4">
          <p class="text-gray-600 mb-4">Necessites iniciar sessió per planificar el teu viatge.</p>
          <div class="space-x-4">
            <NuxtLink to="/login" class="text-blue-600 hover:text-blue-800 underline">
              Iniciar sessió
            </NuxtLink>
            <span class="text-gray-400">o</span>
            <NuxtLink to="/register" class="text-blue-600 hover:text-blue-800 underline">
              Registrar-se
            </NuxtLink>
          </div>
        </div>
      </div>
    </div>
  </div>
</template> 

<script setup>
const user = useState('user', () => null);

const handlePlanTrip = () => {
  if (user.value) {
    navigateTo('/planner');
  } else {
    navigateTo('/login');
  }
};
</script> 