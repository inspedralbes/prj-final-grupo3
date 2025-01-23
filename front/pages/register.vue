<template>
    <div class="min-h-screen bg-gray-50 flex items-center justify-center">
      <div class="max-w-md w-full bg-white rounded-lg shadow-lg p-8">
        <h2 class="text-3xl font-bold text-center mb-8">Crear un compte</h2>
        
        <form @submit.prevent="handleRegister" class="space-y-6">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Nom</label>
            <input 
              type="text" 
              v-model="name"
              required
              class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
              placeholder="Carles"
            >
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Cognom</label>
            <input 
              type="text" 
              v-model="surname"
              required
              class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
              placeholder="Fernández"
            >
          </div>

          <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Data de naixement</label>
                <input 
                  type="date" 
                  v-model="formData.dates"
                  class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                >
              </div>
  
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Correu</label>
            <input 
              type="email" 
              v-model="email"
              required
              class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
              placeholder="elteucorreu@gmail.com"
            >
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Correu alternatiu</label>
            <input 
              type="email" 
              v-model="emailalternative"
              required
              class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
              placeholder="elteucorreu@gmail.com"
            >
          </div>
  
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Contrasenya</label>
            <input 
              type="password" 
              v-model="password"
              required
              minlength="8"
              class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
              placeholder="••••••••"
            >
            <p class="mt-1 text-sm text-gray-500">Mínim  8 caràcters</p>
          </div>
  
          <button 
            type="submit"
            class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 transition duration-200"
          >
            Crear un compte
          </button>
        </form>
  
        <p class="mt-6 text-center text-gray-600">
          Ja tens un compte? 
          <NuxtLink to="/login" class="text-blue-600 hover:text-blue-800 font-medium">
            Inicia sessió aquí
          </NuxtLink>
        </p>
  
        <NuxtLink 
          to="/" 
          class="block mt-4 text-center text-gray-500 hover:text-gray-700"
        >
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

  
  const handleRegister = () => {
    // Here you would typically make an API call to create a new user
    // For demo purposes, we'll just simulate a successful registration
    user.value = { name: name.value, email: email.value };
    navigateTo('/app');
  };
  </script>