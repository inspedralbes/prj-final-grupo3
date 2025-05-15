<template>
  <title>Triplan</title>
  <main class="min-h-screen container flex items-center justify-center mx-auto p-4 py-8">
    <div class="w-full md:w-[70%] bg-white rounded-lg shadow-lg p-6">
      <h2 class="text-3xl font-bold text-center mb-2.5">Planificació del teu viatge</h2>
      <h2 class="text-xl font-bold text-center text-gray-700 mb-8">{{ result.titol.value }}</h2>

      <div class="flex flex-col gap-4" v-if="result.modeVista.value !== 'resum'">
        <div class="flex flex-col gap-4">
          <TargetDay v-for="(dia, i) in result.diesViatge.value" :key="i" :vista="result.modeVista.value" :dia="dia"
            :index="i" :expandit="diaExpandit === i" @toggle="diaExpandit = diaExpandit === i ? null : i" />
        </div>

        <div class="flex items-center justify-between px-2">
          <div class="w-6"></div> <!-- Elemento vacío para equilibrar el layout -->
          <p class="text-md text-center">Mapa complet</p>
          <button @click="showMapAllRoute" class="flex">
            <MapIcon class="w-6 h-6 text-blue-600" />
          </button>
        </div>

        <MapRouteAll :show="mapInteractiveAllRoute" />

        <div class="p-1 text-sm text-gray-400 text-end flex flex-col gap-2">
          <div>
            <p class="text-md font-bold">Preu total:</p>
            <p class="text-xs">{{ result.preuTotal.value }} €</p>
            <p class="text-xs">{{ result.comentaris.value }}</p>
          </div>
        </div>
      </div>

      <!--buttons accept or decline-->
      <div v-if="!result.showConfirmation.value"
        class="flex flex-col md:flex-row md:justify-between mt-8 gap-2 md-gap-0">
        <!--download pdf-->
        <button @click="result.downloadPDF"
          class="text-green-600 hover:text-white border-2 border-green-600 py-2 px-4 rounded-lg hover:bg-green-700 transition duration-500 text-md font-semibold">
          📄 Descarregar PDF
        </button>
        <div class="flex flex-col md:flex-row md:justify-end gap-2">
          <button @click="result.handleAccept"
            class="text-blue-600 py-2 px-4 rounded-lg hover:bg-blue-600 transition duration-200 text-md font-semibold border-2 border-blue-600 hover:text-white">
            Acceptar
          </button>

          <button @click="result.showCancelOptions"
            class="bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700 transition duration-200 text-md font-semibold">
            Cancel·lar
          </button>
        </div>
      </div>

      <!--button for new trip if the user wants to do it-->
      <div v-if="result.showConfirmation.value" class="mt-8 text-center">
        <p class="text-lg font-semibold text-gray-700 mb-4">Estàs segur que vols cancel·lar?</p>
        <div class="flex flex-col md:flex-row justify-between gap-2 md:gap-4">
          <button @click="result.handleCancel"
            class="bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700 transition duration-200 text-md font-semibold">
            Sí, cancel·lar
          </button>
          <button @click="result.generateNewTrip"
            class="bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-200 text-md font-semibold">
            No, generar un nou viatge
          </button>
        </div>
      </div>
    </div>
  </main>
</template>

<script setup>
import { useResult } from '~/composable/useResult';
import { MapIcon } from '@heroicons/vue/24/solid'

const result = useResult();
const diaExpandit = ref(null);
const mapInteractiveAllRoute = ref(true);


const showMapAllRoute = () => {
  mapInteractiveAllRoute.value = !mapInteractiveAllRoute.value
}
</script>

<style>
.custom-prose p {
  margin-bottom: 1.5rem;
}
</style>