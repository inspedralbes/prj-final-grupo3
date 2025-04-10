<template>
  <div v-if="prop.vista === 'pas-a-pas' && dia" class="bg-white rounded-lg shadow-md p-4 border">
    <h3 class="text-xl font-bold mb-3">{{ dia.dia }}</h3>
    <ul class="space-y-2">
      <InfoDay v-for="(act, index) in dia.activitats" :key="index" :act="act" />
    </ul>
  </div>

  <div v-else-if="prop.vista === 'resum' && dia">
    <InfoSummary :summary="prop.dia" />
  </div>

  <div v-else>
    No hi ha cap resultat a mostrar.
  </div>
</template>

<script setup>
const prop = defineProps({
  dia: Object,
  vista: String
});
</script>