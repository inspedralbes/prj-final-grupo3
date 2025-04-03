<template>
    <div v-if="vista === 'pas-a-pas' && dia" class="bg-white rounded-lg shadow-md p-4 border">
      <h3 class="text-xl font-bold mb-3">{{ dia.dia }}</h3>
  
      <ul class="space-y-2">
        <InfoDay v-for="(act, index) in dia.activitats" :key="index" :act="act" />
        <!-- <li v-for="(act, index) in dia.activitats" :key="index" class="border-l-4 border-blue-500 pl-3">
          <p class="text-sm font-semibold text-gray-600">{{ act.hora }}</p>
          <p class="text-base text-gray-800">{{ act.descripcio }}</p>
          <p class="text-sm text-gray-500 italic">Pressupost: {{ act.pressupost }}</p>
        </li> -->
      </ul>
    </div>

    <div v-else-if="vista === 'resum' && dia" >
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <!-- <div v-for="(dia, i) in result.dia.value" :key="i" class="border rounded-lg p-4 shadow-md"> -->
              <h3 class="font-bold text-lg mb-2">Dia {{ dia.dia }} - {{ dia.data }}</h3>
              <ul>
                <li v-for="(act, j) in dia.activitats.slice(0, 2)" :key="j">
                  <strong>{{ act.nom }}</strong>: {{ act.descripcio }}
                </li>
              </ul>
              <p class="text-sm text-gray-600 mt-2">
                Allotjament: {{ dia.allotjament?.nom }}
              </p>
            <!-- </div> -->
        </div>
    </div>

    <div v-else>
        No hi ha cap resultat a mostrar.
    </div>
  </template>

  <script setup>
  defineProps({
    dia : Object,
    vista : String
  });
  </script>