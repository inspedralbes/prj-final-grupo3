<template>
  <li class="border-l-4 border-blue-500 pl-3 bg-white/20 rounded-lg shadow-md p-4">
    <h2 class="text-xl font-semibold text-gray-600 my-0.5">{{ prop.act?.horari }}</h2>
    <h3 class="my-0.5">{{ prop.act?.nom }}</h3>
    <p class="text-base text-gray-800 my-0.5">{{ prop.act?.descripcio }}</p>
    <a :href="prop.act?.ubicacio.google_maps_url" target="_blank"
      class="text-blue-800 hover:border-b hover:border-blue-800">
      {{ prop.act?.ubicacio.nom }}
    </a>
    <p class="text-sm text-gray-500 italic my-0.5">Pressupost: {{ prop.act?.preu }}</p>
  </li>
</template>

<script setup>
const prop = defineProps({
  act: Object
})
</script>