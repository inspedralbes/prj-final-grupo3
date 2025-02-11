<template>
  <title>Triplan</title>
  <div class="min-h-screen bg-gray-50">
    <main class="container mx-auto mt-10 p-4">
      <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-3xl font-bold text-center mb-8">Planificació del teu viatge</h2>

        <div v-if="responseText" v-html="formattedResponseText" class="prose prose-lg max-w-none custom-prose"></div>

        <div v-else>
          <p class="text-lg text-red-500">No hi ha cap resultat a mostrar.</p>
        </div>

        <div v-if="!result.showConfirmation.value" class="flex justify-center gap-x-6 mt-8">
          <button @click="result.handleAccept"
            class="bg-blue-600 text-white py-4 px-8 rounded-lg hover:bg-blue-700 transition duration-200 text-lg font-semibold">
            Acceptar
          </button>

          <button @click="result.showCancelOptions"
            class="bg-red-600 text-white py-4 px-8 rounded-lg hover:bg-red-700 transition duration-200 text-lg font-semibold">
            Cancel·lar
          </button>
        </div>

        <div v-if="result.showConfirmation.value" class="mt-8 text-center">
          <p class="text-lg font-semibold text-gray-700 mb-4">Estàs segur que vols cancel·lar?</p>
          <div class="flex justify-center gap-x-6">
            <button @click="result.handleCancel"
              class="bg-red-600 text-white py-4 px-8 rounded-lg hover:bg-red-700 transition duration-200 text-lg font-semibold">
              Sí, cancel·lar
            </button>
            <button @click="result.generateNewTrip"
              class="bg-blue-600 text-white py-4 px-8 rounded-lg hover:bg-blue-700 transition duration-200 text-lg font-semibold">
              No, generar un nou viatge
            </button>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { useResult } from '~/composable/useResult';
import { useRoute, useRouter } from 'vue-router';
import { computed, ref, watch } from 'vue'; 
import { marked } from 'marked';

const result = useResult();
const route = useRoute();
const router = useRouter();

const response = ref(route.query.response ? JSON.parse(route.query.response) : null);

watch(
  () => route.query.response,
  (newResponse) => {
    response.value = newResponse ? JSON.parse(newResponse) : null;
  }
);

const responseText = computed(() => {
  if (response.value && response.value.candidates && response.value.candidates[0]?.content?.parts[0]?.text) {
    return response.value.candidates[0].content.parts[0].text;
  }
  return null;
});

const formattedResponseText = computed(() => {
  if (responseText.value) {
    return marked(responseText.value);
  }
  return '';
});
</script>

<style>
.custom-prose p {
  margin-bottom: 1.5rem;
}
</style>