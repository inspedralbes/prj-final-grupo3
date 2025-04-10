<template>
  <title>Triplan</title>
  <div class="min-h-screen bg-gray-50">
    <main class="container mx-auto mt-10 p-4">
      <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-3xl font-bold text-center mb-2.5">Planificació del teu viatge</h2>
        <h2 class="text-xl font-bold text-center mb-8">{{ result.titol.value }}</h2>

        <div v-if="result.modeVista.value === 'pas-a-pas' && result.diaActual.value">
          <TargetDay :vista="result.modeVista.value" :dia="result.diaActual.value" />

          <div class="flex flex-col justify-center items-center gap-2 mt-6 ">
            <p class="text-sm text-gray-500">{{ result.diaActualIndex.value + 1 }} de {{ result.diesViatge.value.length
            }}</p>
            <div class="flex justify-center gap-4">
              <button @click="result.mostrarDiaAnterior" class="">
                <!-- No m'agrada -->
                <img src="../assets/images/left.svg" alt="" class="size-8">
              </button>
              <button @click="result.mostrarDiaSeguent" class="">
                <!-- M'agrada -->
                <img src="../assets/images/right.svg" alt="" class="size-8">
              </button>
            </div>
            <button
              class="border-b border-blue-600/50 text-blue-600/50 hover:text-blue-600 transition duration-200 hover:border-blue-600 mt-4"
              @click="result.modeVista.value = 'resum'">Veure resum</button>
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



        <!--buttons accept or decline-->
        <div v-if="!result.showConfirmation.value" class="flex justify-between mt-8">
          <!--download pdf-->
          <div v-if="result.modeVista.value === 'resum'" class="flex">
            <button @click="result.downloadPDF"
              class="text-green-600 hover:text-white border-b-2 border-green-600 py-2 px-4 rounded-t-lg hover:bg-green-700 transition duration-500 text-lg font-semibold">
              📄 Descarregar PDF
            </button>
          </div>
          <div class="flex justify-end gap-2 ml-auto">
            <button @click="result.handleAccept"
              class="text-blue-600 py-2 px-4 rounded-lg hover:bg-blue-600 transition duration-200 text-lg font-semibold border-2 border-blue-600 hover:text-white">
              Acceptar
            </button>

            <button @click="result.showCancelOptions"
              class="bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700 transition duration-200 text-lg font-semibold">
              Cancel·lar
            </button>
          </div>
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