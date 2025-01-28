<template>
  <title>
    Triplan
  </title>
  <div class="min-h-screen bg-gray-50">
    <main class="container mx-auto mt-10 p-4">
      <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-3xl font-bold text-center mb-8">Planificació del teu viatge</h2>

        <!-- Mostrar només el text rellevant -->
        <div v-if="responseText" v-html="formattedResponseText" class="prose prose-lg max-w-none custom-prose"></div>

        <!-- Si no hi ha resposta -->
        <div v-else>
          <p class="text-lg text-red-500">No hi ha cap resultat a mostrar.</p>
        </div>

        <!-- Contenedor de botones -->
        <div class="flex justify-center gap-x-6 mt-8">
          <button class="bg-blue-600 text-white py-4 px-8 rounded-lg hover:bg-blue-700 transition duration-200 text-lg font-semibold">
            Acceptar
          </button>

          <button class="bg-red-600 text-white py-4 px-8 rounded-lg hover:bg-red-700 transition duration-200 text-lg font-semibold">
            Cancel·lar
          </button>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { useRoute } from 'vue-router';
import { computed } from 'vue';
import { marked } from 'marked';

// Captura el resultat de la query
const route = useRoute();
const response = route.query.response ? JSON.parse(route.query.response) : null;

// Extrau el text rellevant de la resposta
const responseText = computed(() => {
  if (response && response.candidates && response.candidates[0]?.content?.parts[0]?.text) {
    return response.candidates[0].content.parts[0].text;
  }
  return null;
});

// Convertir markdown a HTML
const formattedResponseText = computed(() => {
  if (responseText.value) {
    return marked(responseText.value);
  }
  return '';
});
</script>

<style>
/* Añade espaciado adicional entre los párrafos */
.custom-prose p {
  margin-bottom: 1.5rem; /* Ajusta este valor para más o menos espacio */
}
</style>
