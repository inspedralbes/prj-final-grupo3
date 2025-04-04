<template>
  <title>Triplan</title>
  <div class="min-h-screen bg-gray-50">
    <main class="container mx-auto mt-10 p-4">
      <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-3xl font-bold text-center mb-2.5">Planificació del teu viatge</h2>
        <h2 class="text-xl font-bold text-center mb-8">{{ result.titol.value }}</h2>

        <div v-if="result.modeVista.value === 'pas-a-pas' && result.diaActual.value">
          <TargetDay :vista="result.modeVista.value" :dia="result.diaActual.value" />

          <div class="flex justify-center gap-4 mt-6">
            <button @click="result.mostrarSeguentDia"
              class="bg-red-600 text-white py-2 px-6 rounded-lg hover:bg-red-700 transition">
              No m'agrada
            </button>
            <button @click="result.mostrarSeguentDia"
              class="bg-green-600 text-white py-2 px-6 rounded-lg hover:bg-green-700 transition">
              M'agrada
            </button>
          </div>
        </div>


        <!-- Vista resum -->
        <div v-if="result.modeVista.value === 'resum'">
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <TargetDay v-for="(dia, i) in result.diesViatge.value" :key="i" :vista="result.modeVista.value"
              :dia="dia" />
          </div>

          <div class="flex place-content-center mt-4">
            <p class="text-md">
              <strong>Preu total:</strong> {{ result.preuTotal.value }}
            </p>
          </div>
        </div>
        <!-- Si no hi ha dies -->

        <!--download pdf-->
        <div v-if="result.responseText.value" class="flex justify-center mt-6">
          <button @click="result.downloadPDF"
            class="bg-green-600 text-white py-4 px-5 rounded-lg hover:bg-green-700 transition duration-200 text-lg font-semibold">
            📄 Descarregar PDF
          </button>
        </div>

        <!--buttons accept or decline-->
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

        <!--button for new trip if the user wants to do it-->
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

const result = useResult();
</script>

<style>
.custom-prose p {
  margin-bottom: 1.5rem;
}
</style>