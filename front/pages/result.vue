<template>
  <title>Triplan</title>
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

        <!-- Botones principales -->
        <div v-if="!showConfirmation" class="flex justify-center gap-x-6 mt-8">
          <button
            @click="handleAccept"
            class="bg-blue-600 text-white py-4 px-8 rounded-lg hover:bg-blue-700 transition duration-200 text-lg font-semibold"
          >
            Acceptar
          </button>

          <button
            @click="showCancelOptions"
            class="bg-red-600 text-white py-4 px-8 rounded-lg hover:bg-red-700 transition duration-200 text-lg font-semibold"
          >
            Cancel·lar
          </button>
        </div>

        <!-- Confirmación de cancelación -->
        <div v-if="showConfirmation" class="mt-8 text-center">
          <p class="text-lg font-semibold text-gray-700 mb-4">Estàs segur que vols cancel·lar?</p>
          <div class="flex justify-center gap-x-6">
            <button
              @click="handleCancel"
              class="bg-red-600 text-white py-4 px-8 rounded-lg hover:bg-red-700 transition duration-200 text-lg font-semibold"
            >
              Sí, cancel·lar
            </button>
            <button
              @click="generateNewTrip"
              class="bg-blue-600 text-white py-4 px-8 rounded-lg hover:bg-blue-700 transition duration-200 text-lg font-semibold"
            >
              No, generar un nou viatge
            </button>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { useRoute, useRouter } from 'vue-router';
import { computed, ref, watch } from 'vue'; // Añade 'watch' aquí
import { marked } from 'marked';

// Captura el resultat de la query
const route = useRoute();
const router = useRouter();
const response = ref(route.query.response ? JSON.parse(route.query.response) : null); // Usa 'ref' para reactividad

// Observa cambios en route.query.response
watch(
  () => route.query.response,
  (newResponse) => {
    response.value = newResponse ? JSON.parse(newResponse) : null;
  }
);

// Extrau el text rellevant de la resposta
const responseText = computed(() => {
  if (response.value && response.value.candidates && response.value.candidates[0]?.content?.parts[0]?.text) {
    return response.value.candidates[0].content.parts[0].text;
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

// Mostrar opciones de confirmación
const showConfirmation = ref(false);

// Función para manejar el clic en "Acceptar"
const handleAccept = () => {
  alert("Planning del viatge guardat correctament");
  router.push("/"); // Redirigir a la página principal
};

// Mostrar las opciones de confirmación
const showCancelOptions = () => {
  showConfirmation.value = true;
};

// Función para manejar la confirmación de "Sí, cancel·lar"
const handleCancel = () => {
  alert("El viatge s'ha cancel·lat.");
  router.push("/"); // Redirigir a la página principal
};

// Función para manejar "No, generar un nou viatge"
// async function generateNewTrip() {
//   try {
//     console.log('Generarnt un nou viatge...');
//     const response = await fetch('/api/gemini', {
//       method: 'POST',
//       headers: {
//         'Content-Type': 'application/json',
//       },
//       body: JSON.stringify({ 
//         text: "Genera un nou planning de viatge" // Aquí puedes enviar los datos necesarios para generar un nuevo viaje
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

//   } catch (error) {
//     console.error('Error al generar un nou viatge:', error);
//   }
// }
async function generateNewTrip() {
  try {
    console.log('Generando un nuevo viaje con los datos anteriores...');

    // Asegúrate de que 'responseText' contiene los datos relevantes del viaje anterior
    const previousDataText = responseText.value;

    // Crear el mensaje para la API, incluyendo los datos previos
    const newTripMessage = `
      Hazme un nuevo viaje basándote en estos datos:
      ${previousDataText}
    `;

    // Enviar los datos anteriores y el mensaje para generar un nuevo plan
    const response = await fetch('/api/gemini', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({ 
        text: newTripMessage // Aquí estamos enviando el mensaje que incluye los datos previos
      }),
    });

    if (!response.ok) {
      throw new Error('Error en la respuesta del servidor');
    }

    const data = await response.json(); // Aquí se espera un JSON válido
    console.log('Respuesta del servidor:', data);

    // Redirigir a la misma página pero con la nueva respuesta
    router.push({
      path: '/result',
      query: { response: JSON.stringify(data) }
    });

    showConfirmation.value = false;

  } catch (error) {
    console.error('Error al generar un nuevo viaje:', error);
  }
}



</script>

<style>
/* Añade espaciado adicional entre los párrafos */
.custom-prose p {
  margin-bottom: 1.5rem; /* Ajusta este valor para más o menos espacio */
}
</style>