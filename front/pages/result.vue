<template>
  <title>Triplan</title>
  <div class="min-h-screen bg-gray-50">
    <main class="container mx-auto mt-10 p-4">
      <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-3xl font-bold text-center mb-8">Planificació del teu viatge</h2>

        <!-- only text for planning -->
        <div v-if="responseText" v-html="formattedResponseText" class="prose prose-lg max-w-none custom-prose"></div>

        <!-- if not have response we show a message -->
        <div v-else>
          <p class="text-lg text-red-500">No hi ha cap resultat a mostrar.</p>
        </div>

        <!-- principal buttons -->
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

        <!-- confirmation for cancelation -->
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

// function to stay alert if the new response changes
watch(
  () => route.query.response,
  (newResponse) => {
    response.value = newResponse ? JSON.parse(newResponse) : null;
  }
);

// only select the text that we want to show
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
// import { computed, ref, watch } from 'vue'; 
// import { marked } from 'marked';

// // Captura el resultat de la query
// const response = ref(route.query.response ? JSON.parse(route.query.response) : null); 

// // function to stay alert if the new response changes
// watch(
//   () => route.query.response,
//   (newResponse) => {
//     response.value = newResponse ? JSON.parse(newResponse) : null;
//   }
// );

// // only select the text that we want to show
// const responseText = computed(() => {
//   if (response.value && response.value.candidates && response.value.candidates[0]?.content?.parts[0]?.text) {
//     return response.value.candidates[0].content.parts[0].text;
//   }
//   return null;
// });

// // convert markdown to html
// const formattedResponseText = computed(() => {
//   if (responseText.value) {
//     return marked(responseText.value);
//   }
//   return '';
// });

// // show option for confirmation
// const showConfirmation = ref(false);
// const showCancelOptions = () => {
//   showConfirmation.value = true;
// };

// // function if we accept the plan
// const handleAccept = () => {
//   alert("Planning del viatge guardat correctament");
//   router.push("/"); 
// };

// // function for cancelation to return to home
// const handleCancel = () => {
//   alert("El viatge s'ha cancel·lat.");
//   router.push("/");
// };

// // function to generate a new trip
// async function generateNewTrip() {
//   try {
//     console.log('Generando un nuevo viaje con los datos anteriores...');

//     // Asegúrate de que 'responseText' contiene los datos relevantes del viaje anterior
//     const previousDataText = responseText.value;
//     router.push({ name: 'loading' });
//     // Crear el mensaje para la API, incluyendo los datos previos
//     const newTripMessage = `
//       Hazme un nuevo viaje basándote en estos datos:
//       ${previousDataText}
//     `;

//     // Enviar los datos anteriores y el mensaje para generar un nuevo plan
//     const response = await fetch('/api/gemini', {
//       method: 'POST',
//       headers: {
//         'Content-Type': 'application/json',
//       },
//       body: JSON.stringify({
//         text: newTripMessage // Aquí estamos enviando el mensaje que incluye los datos previos
//       }),
//     });

//     if (!response.ok) {
//       throw new Error('Error en la respuesta del servidor');
//     }

//     const data = await response.json(); // Aquí se espera un JSON válido
//     console.log('Respuesta del servidor:', data);

//     // Redirigir a la misma página pero con la nueva respuesta
//     router.push({
//       path: '/result',
//       query: { response: JSON.stringify(data) }
//     });

//     showConfirmation.value = false;

//   } catch (error) {
//     console.error('Error al generar un nuevo viaje:', error);
//   }
// }
</script>

<style>
.custom-prose p {
  margin-bottom: 1.5rem;
}
</style>