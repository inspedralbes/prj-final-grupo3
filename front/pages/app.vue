<template>
    <div class="min-h-screen bg-gray-50">
      <!-- Navigation Bar -->
      <!-- <nav class="bg-white shadow-md p-4">
        <div class="container mx-auto flex justify-between items-center">
          <h1 class="text-2xl font-bold text-blue-600">Triplan</h1>
          <div class="space-x-4">
            <button class="px-4 py-2 text-blue-600 hover:text-blue-800"><NuxtLink to ="/login">Iniciar sessió</NuxtLink></button>
            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700"><NuxtLink to ="/register">Registrar-se</NuxtLink></button>
          </div>
        </div>
      </nav> -->
  
      <!-- Main Content -->
      <main class="container mx-auto mt-10 p-4">
        <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-lg p-6">
          <h2 class="text-3xl font-bold text-center mb-8">Planifica el viatge dels teus somnis</h2>
          
          <form @submit.prevent="handleSubmit" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- Destination -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Destí</label>
                <input 
                  type="text" 
                  v-model="formData.destination"
                  class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                  placeholder="On vols anar?"
                >
              </div>
  
              <!-- Travel Dates -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Dates del viatge</label>
                <input 
                  type="date" 
                  v-model="formData.dates"
                  class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                >
              </div>
  
              <!-- Number of Travelers -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nombre de viatgers</label>
                <input 
                  type="number" 
                  v-model="formData.travelers"
                  min="1"
                  class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                >
              </div>
  
              <!-- Budget -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Pressupost</label>
                <input 
                  type="number" 
                  v-model="formData.budget"
                  class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                  placeholder="El teu pressupost en €"
                >
              </div>
            </div>
  
            <!-- Interests -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Interessos</label>
              <textarea 
                v-model="formData.interests"
                class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                rows="3"
                placeholder="Que t'interessa? (e.x., cultura, aventura, relax)" 
              ></textarea>
            </div>
  
            <button 
              type="submit"
              class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 transition duration-200"
            >
            Planifica el meu viatge
            </button>
          </form>
        </div>
      </main>
    </div>
  </template>
  
  <script setup>
  const formData = ref({
    destination: '',
    dates: '',
    travelers: 1,
    budget: '',
    interests: ''
  });
  
  const handleSubmit = () => {
    console.log('Form submitted:', formData.value);
    // Handle form submission logic here
  };
  </script>