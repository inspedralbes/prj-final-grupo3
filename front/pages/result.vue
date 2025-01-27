<template>
    <div class="min-h-screen bg-gray-50">
      <main class="container mx-auto mt-10 p-4">
        <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-lg p-6">
          <h2 class="text-3xl font-bold text-center mb-8">Resultat del teu viatge</h2>
          <div v-if="response">
            <p class="text-lg">
              {{ response }}
            </p>
          </div>
          <div v-else>
            <p class="text-lg text-red-500">No hi ha cap resultat a mostrar.</p>
          </div>
        </div>
      </main>
    </div>
  </template>
  
  <script setup>
  import { useRoute } from 'vue-router';
  
  // Captura el resultat de la query
  const route = useRoute();
  const response = route.query.response ? JSON.parse(route.query.response) : null;
  </script>
  