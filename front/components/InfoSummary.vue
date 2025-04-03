<template>
  {{ prop.dia }}
  <div class="h-full">
    <div class="border rounded-lg p-4 shadow-md h-full min-h-[200px] flex flex-col">
      <h3 class="font-bold text-lg mb-2">Dia {{ prop.summary.dia }}</h3>
      <ul class="flex-grow">
        <li v-for="(act, j) in prop.summary.activitats" :key="j" class="mb-2">
          <strong>{{ act.nom }}</strong>: {{ act.descripcio }}
        </li>
      </ul>
      <p class="text-sm text-gray-600 mt-auto pt-4 border-t">
        Allotjament: {{ prop.summary.allotjament }}
      </p>
    </div>
  </div>
</template>

<script setup>
const prop = defineProps({
  summary: {
    type: Object,
    required: true
  }
});
</script>